var MouseUpChecker = new Array();

var Event =
{
	'isPlaying': function(soundObject)
	{
	},
	'isPlayable': function(soundObject)
	{
	},
	'mouseup' : function(object)
	{
		if(typeof(object) == 'undefined')
		{
			object = document;
		}

		if(typeof(object) == 'object')
		{
			MouseUpChecker[object.id] = false;
			object.on('mouseup', function(){
				MouseUpChecker[object.id] = true;
			});

			alert(MouseUpChecker[object.id]);
			return MouseUpChecker[object.id];
			//return EventChecker[];
		}

		$(object).mouseup(function(event){
			return true;
		});

		return false;
	},
	'keypress': function(keyCode, callback)
	{
		$(document).keypress(function(event){
			if(event.keyCode == keyCode)
			{
				callback(event);
			}
		});
	},
	'keyup': function(keyCode, callback)
	{
		$(document).keyup(function(event){
			if(event.keyCode == keyCode)
			{
				callback(event);
			}
		});
	},

	'keydown': function(keyCode)
	{
		$(document).keydown(function(event, callback){
			if(event.keyCode == keyCode)
			{
				callback(event);
			}
		});
	},
	'touchstart': function(object)
	{

	},
	/**
	 * 물체가 생성될 때
	 */
	'createObject' : function(object)
	{

	},
	/**
	 * 물체가 제거될 때
	 */
	'removeObject' : function(object)
	{

	}
}