let base_url = "http://localhost:8080/Project/Phone-And-Computer-Store/";

let url = base_url + "admin/upload/index.php?position=product";

let imageUrl = document.querySelector('input[name="imageUrl"]');

/* IMAGE */

let inputImages = document.querySelectorAll(".images");

inputImages.forEach(function (item, index) {
	item.addEventListener("change", function () {
		let formData = new FormData();

		formData.append("thumbnailUpload", item.files[0]);
		fetch(url, {
			method: "POST",
			body: formData,
		})
			.then((response) =>
				response.json().then((data) => {
					imageUrl.value = data;
					// let path = base_url + data;
					// thumbnail.setAttribute("src", path);
					console.log(data);
				})
			)
			.catch((err) => {
				console.log(err);
			});
	});
});
