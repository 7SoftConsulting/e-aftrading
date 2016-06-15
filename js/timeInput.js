var TimeInputInstances = {} ;
var TimeInputFormats = {
	toTwoDigits : function (val) {
		result = new String(val) ;
		if(val < 10)
			result = "0" + result ;
		return result ;
	},
	currents : {
		"default" : new TimeInputDefaultFormat(),
	}
} ;

function TimeInputData(hours, minutes, seconds) {
	this.hours = (hours == undefined) ? 0 : Number(hours) ;
	this.minutes = (minutes == undefined) ? 0 : Number(minutes) ;
	this.seconds = (seconds == undefined) ? 0 : Number(seconds) ;
}
function TimeInputDefaultFormat() {
	this.accept = function (val) {
		if(val == undefined)
			return false ;
		var pattern = /^\d\d\:\d\d\:\d\d$/ ;
		return pattern.exec(val) != null ;
	} ;
	this.encode = function (data) {
		return TimeInputFormats.toTwoDigits(data.hours) + ":" + TimeInputFormats.toTwoDigits(data.minutes) + ":" + TimeInputFormats.toTwoDigits(data.seconds) ;
	} ;
	this.decode = function (val) {
		var attrs = val.split(":") ;
		return new TimeInputData(Number(attrs[0]), Number(attrs[1]), Number(attrs[2])) ;
	}
}
function TimeInput(editorName, value) {
	this.toEditorName = function (val) {
		if(val == undefined)
			return null ;
		var pattern = /[^a-zA-Z0-9_ \-\[\]\&\$]/ ;
		var match = pattern.exec(val) ;
		if(match != null)
		{
			return null ;
		}
		return val ;
	}
	this.render = function () {
		if(this.editorName == null)
			return ;
		this.renderComboBoxPart('hours'+ this.editorName, 0, 23, this.data.hours, 'timeInputUpdateData(this, \'' + this.editorName + '\')') ;
		document.write(" : ") ;
		this.renderComboBoxPart('minutes'+ this.editorName, 0, 59, this.data.minutes, 'timeInputUpdateData(this, \'' + this.editorName + '\')') ;
		document.write(" : ") ;
		this.renderComboBoxPart('seconds'+ this.editorName, 0, 59, this.data.seconds, 'timeInputUpdateData(this, \'' + this.editorName + '\')') ;
		document.write('<input type="' + ((this.hideEditorValue) ? 'hidden' : 'text') +'" name="' + this.editorName + '" value="' + this.format.encode(this.data) + '" />') ;
	}
	this.renderComboBoxPart = function(editorName, min, max, selectedValue, onChangeEvent) {
			var i;
			var optTitle ;
			document.writeln('<select id="' + editorName + '" onchange="' + onChangeEvent + '">') ;
			for(i=min; i<=max; i++) {
				optTitle = i ;
				if(optTitle < 10) {
					optTitle = '0' + optTitle ;
				}
				document.write('<option value="' + i + '"') ;
				if(i == selectedValue) {
					document.write(' selected') ;
				}
				document.writeln('>') ;
				document.writeln(optTitle) ;
				document.writeln('</option>') ;
			}
			document.writeln('</select>') ;
		}
	this.updateData = function () {
		var elemHours = document.getElementById("hours" + this.editorName) ;
		var elemMinutes = document.getElementById("minutes" + this.editorName) ;
		var elemSeconds = document.getElementById("seconds" + this.editorName) ;
		var elemEditor = document.getElementsByName(this.editorName) ;
		this.data = new TimeInputData(parseInt(elemHours.value), parseInt(elemMinutes.value), parseInt(elemSeconds.value)) ;
		elemEditor[0].value = this.format.encode(this.data) ;
	}
	this.editorName = this.toEditorName(editorName) ;
	if(this.editorName == null)
	{
		alert("Le nom d'editeur n'a pas le bon format.") ;
		return ;
	}
	this.hideEditorValue = true ;
	this.format = null ;
	this.value = null ;
	this.data = new TimeInputData() ;
	for(var name in TimeInputFormats.currents) {
		if(TimeInputFormats.currents[name].accept(value)) {
			this.format = TimeInputFormats.currents[name] ;
		}
	}
	if(this.format == null) {
		alert("Le format de cette valeur n'est pas supporté : " + value) ;
		return ;
	}
	this.value = value ;
	this.data = this.format.decode(value) ;
	TimeInputInstances[this.editorName] = this ;
}

function timeInputUpdateData(field, editorName) {
	if(TimeInputInstances[editorName] == undefined)
	{
		alert('Editor not set ' + editorName) ;
		return ;
	}
	TimeInputInstances[editorName].updateData() ;
}

function drawTimeInput(editorName, val) {
	ti = new TimeInput(editorName, (val == null || val == "") ? '00:00:00' : val) ;
	if(ti)
	{
		ti.render() ;
	}
	return ti ;
}


