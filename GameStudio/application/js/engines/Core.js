var GSStage;
var GSLayers = new Array();
var GSObjects = new Array();
var GSCore =
{
	'sequence' : 0,
	'sounds' : new Array(),
	'createSound': function(filepath)
	{
		var id = this.getNextSequence();

		$('<div id="sound_' + id + '" style="display:none;"></div>').appendTo('body');

		this.sounds[id] = filepath;

		return id;
	},
	'removeSound' : function(targetSound)
	{
		if(typeof(targetSound) == 'number')
		{
			$('#sound_' + targetSound).remove();
			this.sounds[targetSound] = null;
		}
	},
	'createLayer' : function(id)
	{
		/*var result;

		if(typeof(id) == 'undefined')
		{
			var id = this.getNextSequence();
		}*/

		var layer = new Kinetic.Layer();
		layer.id = id;

     	GSLayers[id] = layer;

     	return layer;
	},
	'createTriangle' : function(id, x, y, width, bgColor, borderColor, borderWidth)
	{
      return this._createObject(id, {
        x: x,
        y: y,
        sides: 3,
        radius: width,
        fill: bgColor,
        stroke: borderColor,
        strokeWidth: borderWidth
      });

	},
	'_createObject' : function(id, argument)
	{
		if(!id) return false;

     	GSObjects[id] = new Kinetic.RegularPolygon(argument);
     	return GSObjects[id];
	},

	'removeObject' : function(id)
	{
		GSObjects[id].remove();
		GSObjects[id] = null;
	},
	'destoryObject' : function(id)
	{
		GSObjects[id].destory();
		GSObjects[id] = null;
	},
	'getObject' : function(id)
	{
		return GSObjects[id];
	},

	'getLayer' : function(id)
	{
		return GSLayers[id];
	},
	'init': function(canvasWidth, canvasHeight)
	{
		if(!canvasWidth || typeof(canvasWidth) == 'undefined')
		{
			canvasWidth = 600;
		}

		if(!canvasHeight || typeof(canvasHeight) == 'undefined')
		{
			canvasHeight = 400;
		}

		if(this.sounds.length > 0)
		{
			$.each(this.sounds, function(id, filepath)
			{
				/*$('#sound_' + id).jPlayer({
					ready: function () {
						/*$(this).jPlayer("setMedia", {
							m4a: "/media/mysound.mp4",
							oga: "/media/mysound.ogg"
						});
						$(this).jPlayer("setMedia", {
							m4a: "/media/mysound.mp4",
							oga: "/media/mysound.ogg"
						});
					},
					swfPath: "/js",
					supplied: "m4a, oga"
				});*/
			});
		}

		GSStage = new Kinetic.Stage({
			container: 'canvas',
			width: canvasWidth,
			height: canvasHeight
		});
	},
	'getNextSequence': function()
	{
		return this.sequence++;
	}
}