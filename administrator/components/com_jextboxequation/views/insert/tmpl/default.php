<?php

/**
 * @version    2.12.1
 * @package    JExtBOX Equation
 * @author     Galaa
 * @copyright  2016-2021 Galaa
 * @license    GNU General Public License version 2 or later
 */

// no direct access
defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.combobox');
JHtml::_('formbehavior.chosen', 'select', null, array('disable_search_threshold' => 0));

$editor = JFactory::getApplication()->input->getCmd('editor_name', '');

$com_parameters = JComponentHelper::getParams('com_jextboxequation');
$doc = JFactory::getDocument();
// MathJax configuration
$doc->addScriptDeclaration("MathJax.Hub.Config({ showProcessingMessages: false, tex2jax: { inlineMath: [['$','$'],['\\(','\\)']] }, showMathMenu: false, messageStyle: 'none' });", 'text/x-mathjax-config');
// Version
$version = $com_parameters->get('version', '2.7.7');
if (preg_match('/^2\.[0-9]+\.[0-9]+$/', $version))
{
	$localmathjax = JUri::base().'../'.trim($com_parameters->get('localmathjax', 'media/MathJax'), '/').'/MathJax.js?config=TeX-MML-AM_CHTML';
}
else
{
	$version = '2.7.7';
	$localmathjax = null;
}
// CDN
$doc->addScript('//cdnjs.cloudflare.com/ajax/libs/mathjax/'.$version.'/MathJax.js?config=TeX-MML-AM_CHTML', 'text/javascript', false, true);
// Fallback to Local Installation
if (!is_null($localmathjax))
{
	$doc->addScriptDeclaration('window.MathJax || document.write(\'<script src="'.$localmathjax.'"><\/script>\');');
}

?>

<div id="for-escape" style="visibility:hidden"></div>

<form action="<?php echo JRoute::_('index.php?option=com_jextboxequation&view=insert&tmpl=component');?>" method="post" class="form-validate">
	<div class="form-horizontal">
		<div class="row">
			<?php foreach (array('type', 'template', 'equation', 'pspicture') as $control) { ?>
			<div class="span12 form-horizontal inputs" id="input-<?php echo $control; ?>">
				<fieldset class="adminform">
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel($control); ?></div>
						<div class="controls"><?php echo $this->form->getInput($control); ?></div>
					</div>
				</fieldset>
			</div>
			<?php } ?>
			<div class="span12 form-horizontal">
				<fieldset class="adminform">
					<div class="control-group">
						<div class="controls">
							<button class="btn btn-primary" onclick="if (window.parent) window.parent.insertJExtBOXEquation(getInput(),'<?php echo $editor; ?>');return false;">
								<?php echo JText::_('COM_JEXTBOXEQUATION_FORM_BTN_INSERT'); ?>
							</button>
						</div>
					</div>
				</fieldset>
			</div>
			<div class="span12 form-horizontal inputs" id="preview">
				<fieldset class="adminform">
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('preview'); ?></div>
						<div class="controls">
							<div id="jform_preview"></div>
							<div id="jform_buffer" style="visibility:hidden"></div>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
</form>

<script>
var Preview = {
  delay: 150,        // delay after keystroke before updating

  preview: null,     // filled in by Init below
  buffer: null,      // filled in by Init below

  timeout: null,     // store setTimout id
  mjRunning: false,  // true when MathJax is processing
  mjPending: false,  // true when a typeset has been queued
  oldText: null,     // used to check if an update is needed

  //
  //  Get the preview and buffer DIV's
  //
  Init: function () {
    this.preview = document.getElementById("jform_preview");
    this.buffer = document.getElementById("jform_buffer");
  },

  //
  //  Switch the buffer and preview, and display the right one.
  //  (We use visibility:hidden rather than display:none since
  //  the results of running MathJax are more accurate that way.)
  //
  SwapBuffers: function () {
    var buffer = this.preview, preview = this.buffer;
    this.buffer = buffer; this.preview = preview;
    buffer.style.visibility = "hidden"; buffer.style.position = "absolute";
    preview.style.position = ""; preview.style.visibility = "";
  },

  //
  //  This gets called when a key is pressed in the textarea.
  //  We check if there is already a pending update and clear it if so.
  //  Then set up an update to occur after a small delay (so if more keys
  //    are pressed, the update won't occur until after there has been 
  //    a pause in the typing).
  //  The callback function is set up below, after the Preview object is set up.
  //
  Update: function () {
    if (this.timeout) {clearTimeout(this.timeout)}
    this.timeout = setTimeout(this.callback,this.delay);
  },

  //
  //  Creates the preview and runs MathJax on it.
  //  If MathJax is already trying to render the code, return
  //  If the text hasn't changed, return
  //  Otherwise, indicate that MathJax is running, and start the
  //    typesetting.  After it is done, call PreviewDone.
  //  
  CreatePreview: function () {
    Preview.timeout = null;
    if (this.mjPending) return;
    var text = document.getElementById("jform_equation").value;
    if (text === this.oldtext) return;
    if (this.mjRunning) {
      this.mjPending = true;
      MathJax.Hub.Queue(["CreatePreview",this]);
    } else {
      this.oldtext = text;
      this.buffer.innerHTML = text.replace("\\(", "$").replace("\\)", "$");
      this.mjRunning = true;
      MathJax.Hub.Queue(
	["Typeset",MathJax.Hub,this.buffer],
	["PreviewDone",this]
      );
    }
  },

  //
  //  Indicate that MathJax is no longer running,
  //  and swap the buffers to show the results.
  //
  PreviewDone: function () {
    this.mjRunning = this.mjPending = false;
    this.SwapBuffers();
  }

};

//
//  Cache a callback to the CreatePreview action
//
Preview.callback = MathJax.Callback(["CreatePreview",Preview]);
Preview.callback.autoReset = true;  // make sure it can run more than once

// to Init live preview
Preview.Init();

// Main Scripts
js = jQuery.noConflict();

js(document).ready(function(){

	type_change();

	js('#jform_type').change( function(){
		type_change();
	});

	function type_change(){

		js('.inputs').hide();
		js('#input-type').show();
		if(js('#jform_type').val() == 'equation'){ // equation
			js('#input-template').show();
			js('#input-equation').show();
			js('#preview').show();
		}else{ // pspicture
			js('#input-pspicture').show();
		}

	}

	// for live preview
	js('#jform_equation').keyup( function(){
		Preview.Update();
	});

	js('#jform_template').on('change', function() {
		var caretPos = document.getElementById("jform_equation").selectionStart;
		var textAreaTxt = js("#jform_equation").val();
		var txtToAdd = this.value;
		if (textAreaTxt.length == 0) {
			txtToAdd = '$' + txtToAdd + '$';
		}
		js("#jform_equation").val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));
		document.getElementById("jform_equation").selectionStart = caretPos + txtToAdd.length;
		Preview.Update();
		js('#jform_template').val(0);
		js('#jform_template').trigger("liszt:updated");
	});

});

function getInput(){

	// select math
	if(js('#jform_type').val() == 'equation'){ // equation
		var math = js('#jform_equation').val();
	}else{ // pspicture
		var math = js('#jform_pspicture').val();
	}

	// escape HTML chars
	math = js('#for-escape').text(math).html();

	// line break
	while (math.indexOf("\n") !== -1) {
		math = math.replace("\n", "<br />");
	}

	// result
	return math;

}
</script>
