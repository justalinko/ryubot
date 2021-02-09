var express = require('express');
var router = express.Router();

router.post('/' , function(req,res,next){
	var post = req.body;
	
	var log_bot = post.log_bot;
	var log_visitor = post.log_visitor;
	var one_time = post.one_time_access;
	var activebot = post.bot;
	var xdefault = post.direct_default;
	var onetime = post.direct_onetime;
	var dbot = post.direct_bot;

	var catchCode = post.by_country_code;
	var catchVal = post.by_country_value;

	var ByCon = catchVal.map(function(obj,index){
		var myObj = {};
		myObj[catchCode[index]]= obj;
		return myObj;
	});
	var template = {log_bot: log_bot ,
					log_visitor: log_visitor,
					one_time_access: one_time,
					bot:{
						ua:activebot,
						ip:activebot
					},
					direct:{
						default: xdefault,
						bot: dbot,
						onetime: onetime
					},
					by_country: ByCon
				}

	// console.log(JSON.beautify(template));



	res.send('holla');
});

module.exports = router;