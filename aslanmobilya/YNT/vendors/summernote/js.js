(function() {
	var content = "";
	var $sumNote = $("#ta-1").summernote({
		callbacks: {
			onPaste: function(e,x,d) {
				$sumNote.code(($($sumNote.code()).find("font").remove()));
			},
			onImageUpload: function(files, $sumNote, welEditable) {
				sendFile(files[0],$sumNote,welEditable);
			}
		},

		dialogsInBody: true,
		dialogsFade: true,
		disableDragAndDrop: true,
		//                disableResizeEditor:true,
		height: "550px",
		tableClassName: function() {
			alert("tbl");
			$(this)
			.addClass("table table-bordered")

			.attr("cellpadding", 0)
			.attr("cellspacing", 0)
			.attr("border", 1)
			.css("borderCollapse", "collapse")
			.css("table-layout", "fixed")
			.css("width", "100%");

			$(this)
			.find("td")
			.css("borderColor", "#ccc")
			.css("padding", "4px");
		}
	})
	.data("summernote");

	function sendFile(file, $editor, welEditable) {
		data = new FormData();
		data.append("file", file);
		url = "saveimage.php";
		$.ajax({
			data: data,
			type: "POST",
			url: url,
			cache: false,
			contentType: false,
			processData: false,
			success: function(url) {
				var image = $('<img>').attr('src', '//' + url);
				$("#ta-1").summernote("insertNode", image[0]);
			},
			error: function(data) {
				console.log(data);
			}
		});
	}

	//get
	$("#btn-get-content").on("click", function() {
		var y =$($sumNote.code());

		console.log(y[0]);console.log(y.find("p> font"));
		var x = y.find("font").remove();		
		$("#content").text($("#ta-1").val());
	});
	//get text$($sumNote.code()).find("font").remove()$($sumNote.code()).find("font").remove()
	$("#btn-get-text").on("click", function() {
		$("#content").html($($sumNote.code()).text());
	});
	//set
	$("#btn-set-content").on("click", function() {
		$sumNote.code(content);
	}); //reset
	$("#btn-reset").on("click", function() {
		$sumNote.reset();
		$("#content").empty();
	});
})();