//add media script
(() => {
  const state = {
    media: [], //property {name,size,type,file}
    uploadedMedia: [], // property {filename,html,icontag,id,mimetype,response,type,url}
  };

  const addMedia = (file) => {
    const MediaExist = state.media.find(
      (cur) => cur.name === file.name && cur.size === file.size
    );
    if (MediaExist) return false;
    const media = { name: file.name, size: file.size, type: file.type, file };
    state.media.push(media);
    return media;
  };

  const removeMedia = (id) => {
    //find uploaded media with id
    const uploadedMediaIndex = state.uploadedMedia.findIndex(
      (cur) => cur.id === parseInt(id)
    );
    if (uploadedMediaIndex < 0) return;

    //delete the media from both places
    state.uploadedMedia.splice(uploadedMediaIndex, 1);
    state.media.splice(uploadedMediaIndex, 1);
    //re render medias
    renderUploadedMediasPreview();
    activateUploadBtn();
  };

  //type params 'open' or 'close'
  const togglePopup = (type) => {
    const popup = document.querySelector(".media-upload-popup-container");
    if (type === "open") {
      popup.classList.remove("hide-popup");
      return;
    }
    if (type === "close") {
      popup.classList.add("hide-popup");
    }
  };

  const activateUploadBtn = () => {
    const uploadBtn = document.getElementById("popup-upload");
    if (!uploadBtn || state.uploadedMedia.length <= 0) return; //gurd close

    uploadBtn.removeAttribute("disabled");
  };

  //type media is media object ex: e.target.files[0]
  const uploadLoadingScreen = (media) => {
    const reader = new FileReader(media);
    reader.readAsDataURL(media);

    reader.addEventListener("load", () => {
      const markup = `<div class="upload-loading-screen">
    			<span class="upload-loading"></span>
	  		<img src="${reader.result}"/>
	  	    </div>`;
      const previwContainer = document.querySelector(".upload-ready-medias");
      previwContainer.insertAdjacentHTML("beforeend", markup);
    });
  };

  //type params 'off' or 'on'
  const activityUpdateLoadingScreen = (type) => {
    const popup = document.querySelector(".media-upload-popup");
    const loading = document.querySelector(".activity-uploading-loading");
    if (type === "on") {
      popup.style.filter = "contrast(0.5)";
      loading.style.visibility = "visible";
    }
    if (type === "off") {
      popup.style.filter = "none";
      loading.style.visibility = "hidden";
    }
  };

  const uploadMedia = async (media) => {
    const form = new FormData();
    //prepare the form for upload
    form.append("action", "activity_upload");
    form.append("file_name", media.name);
    form.append("upload_file", media.file);
    //loading screen
    uploadLoadingScreen(media.file);

    try {
      const res = await jQuery.ajax({
        url: Metafans_JS.ajaxurl,
        type: "POST",
        dataType: "json",
        data: form,
        processData: false,
        contentType: false,
      });
      state.uploadedMedia.push(res);
    } catch (err) {
      console.log(err);
    }
  };

  const updateMediaUploadActivity = async () => {
    //prepare the form for submit
    const content = document.getElementById("media-caption").value;
    let accessibility = document.getElementById(
      "mf-activity-accessibility"
    ).value;
    if (!accessibility) accessibility = "public";
    //convert all uploaded medias id into comma separate string
    //server wants that format. EX:'123,434,323';
    const medias = state.uploadedMedia.map((cur) => cur.id).join(", "); // spance is need after (,)

    const payload = {
      "whats-new-post-content": content,
      "whats-new-post-url-preview": "",
      "whats-new-post-media": medias,
      "whats-new-post-in": "0",
      "whats-new-post-object": "groups",
      activity_accessibility: accessibility,
    };

    try {
      const res = await jQuery.ajax({
        url: Metafans_JS.ajaxurl,
        type: "POST",
        data: {
          action: "th_bp_post_update",
          data: payload,
        },
      });
      return true; //true means update successfull
    } catch (err) {
      console.error(err);
      return false;
    }
  };

  const renderUploadedMediasPreview = () => {
    const markup = state.uploadedMedia
      .map((cur) => {
        return `<div class="uploaded-image-preview">
      		${cur.html}
		<svg data-id=${cur.id} id="remove-media" width="20" height="20"  viewBox="0 0 32 32"><path d="m17.414 16 6.293-6.293a1 1 0 0 0 -1.414-1.414l-6.293 6.293-6.293-6.293a1 1 0 0 0 -1.414 1.414l6.293 6.293-6.293 6.293a1 1 0 1 0 1.414 1.414l6.293-6.293 6.293 6.293a1 1 0 0 0 1.414-1.414z"></path></svg>
	      </div>`;
      })
      .join(" ");
    const previwContainer = document.querySelector(".upload-ready-medias");
    previwContainer.innerHTML = markup;
  };

  const cleanStateAndDom = () => {
    //clean the state
    state.media = [];
    state.uploadedMedia = [];
    //clean the dom
    document.querySelector(".upload-ready-medias").innerHTML = "";
    document.querySelector("#media-caption").value = "";
    //reload page (temporary)
    location.reload();
  };

  window.addEventListener("load", () => {
    const mediaUploadInput = document.getElementById("media-upload-btn");
    const crossPopupIcon = document.querySelector(".close-media-popup");
    const mediaUploadBtn = document.getElementById("bp-upload-image");
    const popupUploadBtn = document.getElementById("popup-upload");
    const uploadReadyMedias = document.querySelector(".upload-ready-medias");

    if (!mediaUploadInput) return; //gurd close

    mediaUploadInput.addEventListener("change", async (e) => {
      const media = addMedia(e.target.files[0]);

      if (!media) return;

      await uploadMedia(media);
      renderUploadedMediasPreview();
      activateUploadBtn();
    });

    crossPopupIcon.addEventListener("click", (e) => {
      togglePopup("close");
    });

    mediaUploadBtn.addEventListener("click", (e) => {
      togglePopup("open");
    });

    popupUploadBtn.addEventListener("click", async (e) => {
      activityUpdateLoadingScreen("on");

      const res = await updateMediaUploadActivity();
      if (!res) return;

      activityUpdateLoadingScreen("off");

      //oparation complete close the popup
      togglePopup("close");

      //clean the state and dom
      cleanStateAndDom();
    });

    uploadReadyMedias.addEventListener("click", (e) => {
      if (e.target.matches("#remove-media")) {
        //get uploaded media id
        const id = e.target.dataset.id;
        if (!id) return;
        removeMedia(id);
      }
    });
  });
})();
// create album script
(() => {
  const state = {
    media: [], //property {name,size,type,file}
    uploadedMedia: [], // property {filename,html,icontag,id,mimetype,response,type,url}
  };
  window.albumState = state;

  const addMedia = (file) => {
    const MediaExist = state.media.find(
      (cur) => cur.name === file.name && cur.size === file.size
    );
    if (MediaExist) return false;
    const media = {
      name: file.name,
      uniqId: Date.now() + Math.floor(Math.random() * 10),
      size: file.size,
      type: file.type,
      file,
    };
    state.media.push(media);
    return media;
  };

  const removeMedia = (id) => {
    //find uploaded media with id
    const uploadedMediaIndex = state.uploadedMedia.findIndex(
      (cur) => cur.id === parseInt(id)
    );
    if (uploadedMediaIndex < 0) return;
    const deletedMedia = state.uploadedMedia[uploadedMediaIndex];

    //find local media from `state.media`;
    const localMedaiIndex = state.media.findIndex(
      (cur) => cur.uniqId === parseInt(deletedMedia.file_uniqId)
    );
    if (localMedaiIndex < 0) return;

    //delete the media from both places
    state.uploadedMedia.splice(uploadedMediaIndex, 1);
    state.media.splice(localMedaiIndex, 1);
    //re-render medias
    renderUploadedMediasPreview();
    activateUploadBtn();
  };

  //type params 'open' or 'close'
  const togglePopup = (type) => {
    const popup = document.querySelector(".album-upload-popup-container");
    if (type === "open") {
      popup.classList.remove("hide-popup");
      return;
    }
    if (type === "close") {
      popup.classList.add("hide-popup");
    }
  };

  const activateUploadBtn = () => {
    const uploadBtn = document.getElementById("album-upload");
    if (!uploadBtn || state.uploadedMedia.length <= 0) return; //gurd close

    uploadBtn.removeAttribute("disabled");
  };

  //type media is media object ex: e.target.files[0]
  const uploadLoadingScreen = (media) => {
    const reader = new FileReader(media);
    reader.readAsDataURL(media);

    reader.addEventListener("load", () => {
      const markup = `<div class="upload-loading-screen">
    			<span class="upload-loading"></span>
	  		<img src="${reader.result}"/>
	  	    </div>`;
      const previwContainer = document.querySelector(
        ".album-upload-ready-medias"
      );
      previwContainer.insertAdjacentHTML("beforeend", markup);
    });
  };

  //type params 'off' or 'on'
  const activityUpdateLoadingScreen = (type) => {
    const popup = document.querySelector(".album-upload-popup");
    const loading = popup.querySelector(".activity-uploading-loading");
    if (type === "on") {
      popup.style.filter = "contrast(0.5)";
      loading.style.visibility = "visible";
    }
    if (type === "off") {
      popup.style.filter = "none";
      loading.style.visibility = "hidden";
    }
  };

  const uploadMedia = async (media) => {
    const form = new FormData();
    //prepare the form for upload
    form.append("action", "activity_upload");
    form.append("file_name", media.name);
    form.append("upload_file", media.file);
    form.append("file_uniqId", media.uniqId);
    //loading screen
    uploadLoadingScreen(media.file);

    try {
      const res = await jQuery.ajax({
        url: Metafans_JS.ajaxurl,
        type: "POST",
        dataType: "json",
        data: form,
        processData: false,
        contentType: false,
      });
      state.uploadedMedia.push(res);
    } catch (err) {
      console.log(err);
    }
  };

  const updateMediaUploadActivity = async (domCon) => {
    //prepare the form for submit
    const content = domCon.querySelector("#album-caption").value;
    let accessibility = domCon.querySelector(
      "#mf-activity-accessibility"
    ).value;
    if (!accessibility) accessibility = "public";
    const albumName = domCon.querySelector("#album-name").value;
    //convert all uploaded medias id into comma separate string
    //server wants that format. EX:'123,434,323';
    const medias = state.uploadedMedia.map((cur) => cur.id).join(", "); // spance is need after (,)

    const payload = {
      "whats-new-post-content": content,
      "whats-new-post-url-preview": "",
      "whats-new-post-media": medias,
      "whats-new-post-in": "0",
      "whats-new-post-object": "groups",
      activity_accessibility: accessibility,
      is_album_activity: {
        name: albumName,
      },
    };

    try {
      const res = await jQuery.ajax({
        url: Metafans_JS.ajaxurl,
        type: "POST",
        data: {
          action: "th_bp_post_update",
          data: payload,
        },
      });
      return true; //true means update successfull
    } catch (err) {
      console.error(err);
      return false;
    }
  };

  const renderUploadedMediasPreview = () => {
    const markup = state.uploadedMedia
      .map((cur) => {
        return `<div class="uploaded-image-preview">
      		${cur.html}
		<svg data-id=${cur.id} id="remove-media" width="20" height="20"  viewBox="0 0 32 32"><path d="m17.414 16 6.293-6.293a1 1 0 0 0 -1.414-1.414l-6.293 6.293-6.293-6.293a1 1 0 0 0 -1.414 1.414l6.293 6.293-6.293 6.293a1 1 0 1 0 1.414 1.414l6.293-6.293 6.293 6.293a1 1 0 0 0 1.414-1.414z"></path></svg>
	      </div>`;
      })
      .join(" ");
    const previwContainer = document.querySelector(
      ".album-upload-ready-medias"
    );
    previwContainer.innerHTML = markup;
  };

  const cleanStateAndDom = () => {
    //clean the state
    state.media = [];
    state.uploadedMedia = [];
    //clean the dom
    document.querySelector(".album-upload-ready-medias").innerHTML = "";
    document.querySelector("#album-caption").value = "";
    //reload page (temporary)
    location.reload();
  };

  window.addEventListener("load", () => {
    const albumCon = document.querySelector(".album-upload-popup-container");
    const albumUploadInput = albumCon.querySelector("#album-upload-btn");
    const crossPopupIcon = albumCon.querySelector(".close-album-popup");
    const mediaUploadBtn = document.querySelector("#bp-create-album");
    const popupUploadBtn = albumCon.querySelector("#album-upload");
    const uploadReadyMedias = albumCon.querySelector(
      ".album-upload-ready-medias"
    );
    const albumName = albumCon.querySelector("#album-name");

    if (!albumCon) return; //gurd close

    albumUploadInput.addEventListener("change", async (e) => {
      const medias = Array.from(e.target.files).map((file) => addMedia(file));
      //remove `false` form medias because false means those this media is exist
      const newMedias = [];
      medias.forEach((media) => {
        if (media !== false) newMedias.push(media);
      });

      if (!newMedias.length) return;

      const promise = newMedias.map((cur) => uploadMedia(cur));
      await Promise.all(promise);
      //await uploadMedia(media);
      renderUploadedMediasPreview();
      activateUploadBtn();
    });

    crossPopupIcon.addEventListener("click", (e) => {
      togglePopup("close");
    });

    mediaUploadBtn.addEventListener("click", (e) => {
      togglePopup("open");
    });

    popupUploadBtn.addEventListener("click", async (e) => {
      //check album name is not empty
      if (albumName.value === "") {
        albumName.style.border = " 1px solid red";
        return;
      }

      activityUpdateLoadingScreen("on");

      const res = await updateMediaUploadActivity(albumCon);
      if (!res) return;

      activityUpdateLoadingScreen("off");

      //oparation complete close the popup
      togglePopup("close");

      //clean the state and dom
      cleanStateAndDom();
    });

    uploadReadyMedias.addEventListener("click", (e) => {
      if (e.target.matches("#remove-media")) {
        //get uploaded media id
        const id = e.target.dataset.id;
        if (!id) return;
        removeMedia(id);
      }
    });
  });
})();

window.addEventListener("load", () => {
  const imgPrevCon = document.querySelector(".mf-photo-previewer");
  const myPhotoDom = document.getElementById("myphoto");
  const myPhotoCountDom = document.getElementById("myphoto-count");
  const allPhotoDom = document.getElementById("allphoto-link");
  const lodingCon = document.getElementById("loading-con");
  const searchForm = document.querySelector(".bp-search-input-box");
  const searchInput = document.getElementById("bp-image-search");
  let i = 0; // i is counter of total images

  async function getImages(type, search_term = "") {
    const res = await jQuery.ajax({
      type: "post",
      url: Metafans_JS.ajaxurl,
      data: {
        action: "mf_activity_search",
        photo_type: type,
        search_term: search_term !== "" ? search_term : "",
      },
    });
    return res;
  }

  function renderImages(imgObj) {
    let markup = [];
    for (const property in imgObj) {
      if (property === "album" || property === "activity_id") {
      } else {
        const html = `<div class="bp-image-single" id=${i}>
			<div class="post-media-single">				
				<a class="media-popup-thumbnail" href="${imgObj[property].thumb[0]}" data-id="${imgObj[property].id}"  data-activity="${imgObj.activity_id}">
					<img src="${imgObj[property].full}" alt="gm" />
				</a>
			</div>
		     </div>`;
        markup.unshift(html);
        i++;
      }
    }
    return markup.join(" ");
  }

  function render(images) {
    i = 0;
    const markup = images
      .map((cur) => {
        if (cur.album) {
          const imagesMarkup = `<div class="mf-album"><svg width="16" height="16" viewBox="0 0 512 512">
<path d="M464,128h-16v-16c0-26.51-21.49-48-48-48h-16V48c0-26.51-21.49-48-48-48H48C21.49,0,0,21.49,0,48v288    c0,26.51,21.49,48,48,48h16v16c0,26.51,21.49,48,48,48h16v16c0,26.51,21.49,48,48,48h288c26.51,0,48-21.49,48-48V176    C512,149.49,490.51,128,464,128z M48,352c-8.837,0-16-7.163-16-16V48c0-8.837,7.163-16,16-16h288c8.837,0,16,7.163,16,16v288    c0,8.837-7.163,16-16,16H48z M112,416c-8.837,0-16-7.163-16-16v-16h240c26.51,0,48-21.49,48-48V96h16c8.837,0,16,7.163,16,16v288    c0,8.837-7.163,16-16,16H112z M480,464c0,8.837-7.163,16-16,16H176c-8.837,0-16-7.163-16-16v-16h240c26.51,0,48-21.49,48-48V160    h16c8.837,0,16,7.163,16,16V464z"></path>
</svg>${renderImages(cur)}</div>`;
          return imagesMarkup;
        } else {
          return renderImages(cur);
        }
      })
      .join(" ");
    return markup;
  }

  async function loadImagesControl(type) {
    //start loading
    changeLoadingState("loading");
    //featch images
    const images = await getImages(type);
    //stop loading
    changeLoadingState();
    //genarate markup
    const markup = render(images);
    //render markup
    imgPrevCon.innerHTML = markup;
  }

  function changeLoadingState(state) {
    if (state === "loading") {
      imgPrevCon.innerHTML = "";
      lodingCon.classList.add("loading-state");
      return;
    }
    lodingCon.classList.remove("loading-state");
  }

  function init() {
    allPhotoDom.addEventListener("click", async (e) => {
      //change active
      myPhotoDom.classList.remove("bp-image-filter-active");
      allPhotoDom.classList.add("bp-image-filter-active");

      loadImagesControl("all");
    });

    myPhotoDom.addEventListener("click", async (e) => {
      //change active
      allPhotoDom.classList.remove("bp-image-filter-active");
      myPhotoDom.classList.add("bp-image-filter-active");

      await loadImagesControl("my");
      //render count
      myPhotoCountDom.innerText = i;
      myPhotoCountDom.style.visibility = "visible";
    });

    searchForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const value = searchInput.value;
      if (!value) return;
      //start loading
      changeLoadingState("loading");
      //featch images
      const images = await getImages("all", value);
      //stop loading
      changeLoadingState();
      //genarate markup
      const markup = render(images);
      //render markup
      imgPrevCon.innerHTML = markup;
    });
  }
  init();
});
