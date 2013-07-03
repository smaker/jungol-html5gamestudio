
var Action = {
	'wait': function(milisecond, func, param)
	{
		if(typeof(param) == 'string')
		{
			setTimeout('func(' + param + ')', milisecond);
		}
	},
	'createTriangle' : function(id, x, y, bgColor, borderColor, borderWidth)
	{
		return GSCore.createTriangle(id, x, y, bgColor, borderColor, borderWidth);
	},
	'createSound': function(filepath)
	{
		return GSCore.createSound(filepath);
	},
	'removeSound' : function(soundObject)
	{
		return GSCore.removeSound(soundObject);
	},
	'pauseSound': function(soundObject)
	{

	},
	'playSound': function(soundObject)
	{

	},
	'stopSound': function(soundObject) {
	},
	'move' : function(object, x, y)
	{
		if(typeof(object) != 'object') return false;

		object.move(x, y);

	},
	'moveTo' : function(object, x, y)
	{
		if(typeof(object) != 'object') return false;

		object.x = x;
		object.y = y;
	}
};