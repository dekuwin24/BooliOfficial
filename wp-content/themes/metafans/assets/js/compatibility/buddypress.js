/****************
 Activity popup script start from here
 *****************/
const visibilityPostFormData = [
  {
    id: 1,
    vi: "public",
    svg: `<svg viewBox="0 0 512 512"><path d="M414.39 97.74A224 224 0 1097.61 414.52 224 224 0 10414.39 97.74zM64 256.13a191.63 191.63 0 016.7-50.31c7.34 15.8 18 29.45 25.25 45.66 9.37 20.84 34.53 15.06 45.64 33.32 9.86 16.21-.67 36.71 6.71 53.67 5.36 12.31 18 15 26.72 24 8.91 9.08 8.72 21.52 10.08 33.36a305.36 305.36 0 007.45 41.27c0 .1 0 .21.08.31C117.8 411.13 64 339.8 64 256.13zm192 192a193.12 193.12 0 01-32-2.68c.11-2.71.16-5.24.43-7 2.43-15.9 10.39-31.45 21.13-43.35 10.61-11.74 25.15-19.68 34.11-33 8.78-13 11.41-30.5 7.79-45.69-5.33-22.44-35.82-29.93-52.26-42.1-9.45-7-17.86-17.82-30.27-18.7-5.72-.4-10.51.83-16.18-.63-5.2-1.35-9.28-4.15-14.82-3.42-10.35 1.36-16.88 12.42-28 10.92-10.55-1.41-21.42-13.76-23.82-23.81-3.08-12.92 7.14-17.11 18.09-18.26 4.57-.48 9.7-1 14.09.68 5.78 2.14 8.51 7.8 13.7 10.66 9.73 5.34 11.7-3.19 10.21-11.83-2.23-12.94-4.83-18.21 6.71-27.12 8-6.14 14.84-10.58 13.56-21.61-.76-6.48-4.31-9.41-1-15.86 2.51-4.91 9.4-9.34 13.89-12.27 11.59-7.56 49.65-7 34.1-28.16-4.57-6.21-13-17.31-21-18.83-10-1.89-14.44 9.27-21.41 14.19-7.2 5.09-21.22 10.87-28.43 3-9.7-10.59 6.43-14.06 10-21.46 1.65-3.45 0-8.24-2.78-12.75q5.41-2.28 11-4.23a15.6 15.6 0 008 3c6.69.44 13-3.18 18.84 1.38 6.48 5 11.15 11.32 19.75 12.88 8.32 1.51 17.13-3.34 19.19-11.86 1.25-5.18 0-10.65-1.2-16a190.83 190.83 0 01105 32.21c-2-.76-4.39-.67-7.34.7-6.07 2.82-14.67 10-15.38 17.12-.81 8.08 11.11 9.22 16.77 9.22 8.5 0 17.11-3.8 14.37-13.62-1.19-4.26-2.81-8.69-5.42-11.37a193.27 193.27 0 0118 14.14c-.09.09-.18.17-.27.27-5.76 6-12.45 10.75-16.39 18.05-2.78 5.14-5.91 7.58-11.54 8.91-3.1.73-6.64 1-9.24 3.08-7.24 5.7-3.12 19.4 3.74 23.51 8.67 5.19 21.53 2.75 28.07-4.66 5.11-5.8 8.12-15.87 17.31-15.86a15.4 15.4 0 0110.82 4.41c3.8 3.94 3.05 7.62 3.86 12.54 1.43 8.74 9.14 4 13.83-.41a192.12 192.12 0 019.24 18.77c-5.16 7.43-9.26 15.53-21.67 6.87-7.43-5.19-12-12.72-21.33-15.06-8.15-2-16.5.08-24.55 1.47-9.15 1.59-20 2.29-26.94 9.22-6.71 6.68-10.26 15.62-17.4 22.33-13.81 13-19.64 27.19-10.7 45.57 8.6 17.67 26.59 27.26 46 26 19.07-1.27 38.88-12.33 38.33 15.38-.2 9.81 1.85 16.6 4.86 25.71 2.79 8.4 2.6 16.54 3.24 25.21a158 158 0 004.74 30.07A191.75 191.75 0 01256 448.13z"/></svg>`,
  },
  {
    id: 2,
    vi: "friends",
    svg: `<svg viewBox="0 0 512 512"><path d="M336 256c-20.56 0-40.44-9.18-56-25.84-15.13-16.25-24.37-37.92-26-61-1.74-24.62 5.77-47.26 21.14-63.76S312 80 336 80c23.83 0 45.38 9.06 60.7 25.52 15.47 16.62 23 39.22 21.26 63.63-1.67 23.11-10.9 44.77-26 61C376.44 246.82 356.57 256 336 256zm66-88zM467.83 432H204.18a27.71 27.71 0 01-22-10.67 30.22 30.22 0 01-5.26-25.79c8.42-33.81 29.28-61.85 60.32-81.08C264.79 297.4 299.86 288 336 288c36.85 0 71 9 98.71 26.05 31.11 19.13 52 47.33 60.38 81.55a30.27 30.27 0 01-5.32 25.78A27.68 27.68 0 01467.83 432zM147 260c-35.19 0-66.13-32.72-69-72.93-1.42-20.6 5-39.65 18-53.62 12.86-13.83 31-21.45 51-21.45s38 7.66 50.93 21.57c13.1 14.08 19.5 33.09 18 53.52-2.87 40.2-33.8 72.91-68.93 72.91zM212.66 291.45c-17.59-8.6-40.42-12.9-65.65-12.9-29.46 0-58.07 7.68-80.57 21.62-25.51 15.83-42.67 38.88-49.6 66.71a27.39 27.39 0 004.79 23.36A25.32 25.32 0 0041.72 400h111a8 8 0 007.87-6.57c.11-.63.25-1.26.41-1.88 8.48-34.06 28.35-62.84 57.71-83.82a8 8 0 00-.63-13.39c-1.57-.92-3.37-1.89-5.42-2.89z"/></svg>`,
  },
  {
    id: 3,
    vi: "onlyme",
    svg: `<svg viewBox="0 0 30 30"><g id="surface67244366"><path style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:1;" d="M 15 2 C 11.144531 2 8 5.144531 8 9 L 8 11 L 6 11 C 4.894531 11 4 11.894531 4 13 L 4 25 C 4 26.105469 4.894531 27 6 27 L 24 27 C 25.105469 27 26 26.105469 26 25 L 26 13 C 26 11.894531 25.105469 11 24 11 L 22 11 L 22 9 C 22 5.273438 19.035156 2.269531 15.355469 2.074219 C 15.242188 2.027344 15.121094 2.003906 15 2 Z M 15 4 C 17.773438 4 20 6.226562 20 9 L 20 11 L 10 11 L 10 9 C 10 6.226562 12.226562 4 15 4 Z M 15 4 "/></g></svg>`,
  },
];
//this fn make the activity post form popup
function toggleActivityPostFormPopup(type) {
  //select activity popup form
  const activityPostFormDom = document.getElementById(
    "bp-nouveau-activity-form"
  );
  if (!activityPostFormDom) return;

  if (type === "open") {
    //add css so it can be popup
    activityPostFormDom.classList.add("activity-post-form-popup");
    //hide the file upload previewer
    const previewar = activityPostFormDom.querySelector(".whats-new-previewer");
    if (!previewar) return;
    previewar.classList.remove("previewer-toggle");
    //show activity post form
    //pre written jQuery
    activityPostFormDom.style.display = "block";
    jQuery("#whats-new-attachments").hide(0, function () {
      jQuery("#whats-new-content").show(0, function () {
        jQuery("#whats-new-attachments").show();
      });
    });

    jQuery(".whats-new-header-media-section").hide(0);
    jQuery(".advanced-th-bp-activity-form").focus();
    jQuery(".whats-new-intro-header").css({
      "font-size": "21px",
      "font-weight": "400",
    });
    jQuery(".whats-new-intro-header").hide();
  }

  if (type === "close") {
    //remove css so it cant be a popup
    activityPostFormDom.classList.remove("activity-post-form-popup");
    //hide the file upload previewer
    const previewar = activityPostFormDom.querySelector(".whats-new-previewer");
    if (!previewar) return;
    //hide activity post form
    activityPostFormDom.style.display = "none";
    previewar.classList.remove("previewer-toggle");
    //reset post activity btn text
    activityPostFormDom.querySelector("#aw-whats-new-submit").value = "Post";
    activityPostFormDom
      .querySelector("#aw-whats-new-submit")
      .setAttribute("disabled", "disabled");
    resetGroupAndViType(activityPostFormDom);
    //clear post box text
    activityPostFormDom.querySelector("#th-bp-whats-new").innerText = "";

    //reset activity post form state
    mf_activity_edite_is_delete_activity = false;
    mf_activity_id_of_current_editeing_activity = false;
    mf_activity_current_editing_activity_dom = false;
  }
}

function renderDefaultVisibility(text, formDom) {
  const nameDom = formDom.querySelector(".what-is-new-avatar-text");
  const markup = `<div id="visibility-handler">
		      <svg class="ionicon" viewBox="0 0 512 512"><path d="M414.39 97.74A224 224 0 1097.61 414.52 224 224 0 10414.39 97.74zM64 256.13a191.63 191.63 0 016.7-50.31c7.34 15.8 18 29.45 25.25 45.66 9.37 20.84 34.53 15.06 45.64 33.32 9.86 16.21-.67 36.71 6.71 53.67 5.36 12.31 18 15 26.72 24 8.91 9.08 8.72 21.52 10.08 33.36a305.36 305.36 0 007.45 41.27c0 .1 0 .21.08.31C117.8 411.13 64 339.8 64 256.13zm192 192a193.12 193.12 0 01-32-2.68c.11-2.71.16-5.24.43-7 2.43-15.9 10.39-31.45 21.13-43.35 10.61-11.74 25.15-19.68 34.11-33 8.78-13 11.41-30.5 7.79-45.69-5.33-22.44-35.82-29.93-52.26-42.1-9.45-7-17.86-17.82-30.27-18.7-5.72-.4-10.51.83-16.18-.63-5.2-1.35-9.28-4.15-14.82-3.42-10.35 1.36-16.88 12.42-28 10.92-10.55-1.41-21.42-13.76-23.82-23.81-3.08-12.92 7.14-17.11 18.09-18.26 4.57-.48 9.7-1 14.09.68 5.78 2.14 8.51 7.8 13.7 10.66 9.73 5.34 11.7-3.19 10.21-11.83-2.23-12.94-4.83-18.21 6.71-27.12 8-6.14 14.84-10.58 13.56-21.61-.76-6.48-4.31-9.41-1-15.86 2.51-4.91 9.4-9.34 13.89-12.27 11.59-7.56 49.65-7 34.1-28.16-4.57-6.21-13-17.31-21-18.83-10-1.89-14.44 9.27-21.41 14.19-7.2 5.09-21.22 10.87-28.43 3-9.7-10.59 6.43-14.06 10-21.46 1.65-3.45 0-8.24-2.78-12.75q5.41-2.28 11-4.23a15.6 15.6 0 008 3c6.69.44 13-3.18 18.84 1.38 6.48 5 11.15 11.32 19.75 12.88 8.32 1.51 17.13-3.34 19.19-11.86 1.25-5.18 0-10.65-1.2-16a190.83 190.83 0 01105 32.21c-2-.76-4.39-.67-7.34.7-6.07 2.82-14.67 10-15.38 17.12-.81 8.08 11.11 9.22 16.77 9.22 8.5 0 17.11-3.8 14.37-13.62-1.19-4.26-2.81-8.69-5.42-11.37a193.27 193.27 0 0118 14.14c-.09.09-.18.17-.27.27-5.76 6-12.45 10.75-16.39 18.05-2.78 5.14-5.91 7.58-11.54 8.91-3.1.73-6.64 1-9.24 3.08-7.24 5.7-3.12 19.4 3.74 23.51 8.67 5.19 21.53 2.75 28.07-4.66 5.11-5.8 8.12-15.87 17.31-15.86a15.4 15.4 0 0110.82 4.41c3.8 3.94 3.05 7.62 3.86 12.54 1.43 8.74 9.14 4 13.83-.41a192.12 192.12 0 019.24 18.77c-5.16 7.43-9.26 15.53-21.67 6.87-7.43-5.19-12-12.72-21.33-15.06-8.15-2-16.5.08-24.55 1.47-9.15 1.59-20 2.29-26.94 9.22-6.71 6.68-10.26 15.62-17.4 22.33-13.81 13-19.64 27.19-10.7 45.57 8.6 17.67 26.59 27.26 46 26 19.07-1.27 38.88-12.33 38.33 15.38-.2 9.81 1.85 16.6 4.86 25.71 2.79 8.4 2.6 16.54 3.24 25.21a158 158 0 004.74 30.07A191.75 191.75 0 01256 448.13z"></path></svg>
	              <span>${text}</span>
	         </div>`;
  //add this markup to dom
  nameDom.insertAdjacentHTML("beforeend", markup);
}

function getgroups(formDom) {
  const groupDom = formDom.querySelectorAll("#whats-new-post-in option");
  if (!groupDom.length) return [];

  return Array.from(groupDom).map((cur, i) => ({
    dom: cur,
    index: i,
    id: cur.value,
    groups: groupDom,
  }));
}

function getVisibility(formDom) {
  const visibilityTypesDom = formDom.querySelectorAll(
    "#mf-activity-accessibility option"
  );

  if (!visibilityTypesDom.length) return [];

  return Array.from(visibilityTypesDom).map((cur, i) => ({
    dom: cur,
    index: i,
    id: Math.round(Math.random() * 50),
    visibilitys: visibilityTypesDom,
  }));
}

function activityVisibilityMarkup() {
  const markup = `
	    <div class="ac-vi-form-pop-main">
	       <div class="ac-vi-form-content">
	         <div class="ac-vi-form-head">
		   <p class="ac-vi-form-header-text">Who can see your post?</p>
		<span class="close-popup">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
					<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
				</svg>
		</span>
		 </div>
		 <div class="ac-vi-form-options">
		   <div class="ac-vi-form-option-public" data-type="public">
			<span class="ac-vi-form-option-svg-bg"><svg  class="ionicon" viewBox="0 0 512 512"><path d="M414.39 97.74A224 224 0 1097.61 414.52 224 224 0 10414.39 97.74zM64 256.13a191.63 191.63 0 016.7-50.31c7.34 15.8 18 29.45 25.25 45.66 9.37 20.84 34.53 15.06 45.64 33.32 9.86 16.21-.67 36.71 6.71 53.67 5.36 12.31 18 15 26.72 24 8.91 9.08 8.72 21.52 10.08 33.36a305.36 305.36 0 007.45 41.27c0 .1 0 .21.08.31C117.8 411.13 64 339.8 64 256.13zm192 192a193.12 193.12 0 01-32-2.68c.11-2.71.16-5.24.43-7 2.43-15.9 10.39-31.45 21.13-43.35 10.61-11.74 25.15-19.68 34.11-33 8.78-13 11.41-30.5 7.79-45.69-5.33-22.44-35.82-29.93-52.26-42.1-9.45-7-17.86-17.82-30.27-18.7-5.72-.4-10.51.83-16.18-.63-5.2-1.35-9.28-4.15-14.82-3.42-10.35 1.36-16.88 12.42-28 10.92-10.55-1.41-21.42-13.76-23.82-23.81-3.08-12.92 7.14-17.11 18.09-18.26 4.57-.48 9.7-1 14.09.68 5.78 2.14 8.51 7.8 13.7 10.66 9.73 5.34 11.7-3.19 10.21-11.83-2.23-12.94-4.83-18.21 6.71-27.12 8-6.14 14.84-10.58 13.56-21.61-.76-6.48-4.31-9.41-1-15.86 2.51-4.91 9.4-9.34 13.89-12.27 11.59-7.56 49.65-7 34.1-28.16-4.57-6.21-13-17.31-21-18.83-10-1.89-14.44 9.27-21.41 14.19-7.2 5.09-21.22 10.87-28.43 3-9.7-10.59 6.43-14.06 10-21.46 1.65-3.45 0-8.24-2.78-12.75q5.41-2.28 11-4.23a15.6 15.6 0 008 3c6.69.44 13-3.18 18.84 1.38 6.48 5 11.15 11.32 19.75 12.88 8.32 1.51 17.13-3.34 19.19-11.86 1.25-5.18 0-10.65-1.2-16a190.83 190.83 0 01105 32.21c-2-.76-4.39-.67-7.34.7-6.07 2.82-14.67 10-15.38 17.12-.81 8.08 11.11 9.22 16.77 9.22 8.5 0 17.11-3.8 14.37-13.62-1.19-4.26-2.81-8.69-5.42-11.37a193.27 193.27 0 0118 14.14c-.09.09-.18.17-.27.27-5.76 6-12.45 10.75-16.39 18.05-2.78 5.14-5.91 7.58-11.54 8.91-3.1.73-6.64 1-9.24 3.08-7.24 5.7-3.12 19.4 3.74 23.51 8.67 5.19 21.53 2.75 28.07-4.66 5.11-5.8 8.12-15.87 17.31-15.86a15.4 15.4 0 0110.82 4.41c3.8 3.94 3.05 7.62 3.86 12.54 1.43 8.74 9.14 4 13.83-.41a192.12 192.12 0 019.24 18.77c-5.16 7.43-9.26 15.53-21.67 6.87-7.43-5.19-12-12.72-21.33-15.06-8.15-2-16.5.08-24.55 1.47-9.15 1.59-20 2.29-26.94 9.22-6.71 6.68-10.26 15.62-17.4 22.33-13.81 13-19.64 27.19-10.7 45.57 8.6 17.67 26.59 27.26 46 26 19.07-1.27 38.88-12.33 38.33 15.38-.2 9.81 1.85 16.6 4.86 25.71 2.79 8.4 2.6 16.54 3.24 25.21a158 158 0 004.74 30.07A191.75 191.75 0 01256 448.13z"/></svg></span>
			<div>
			   <p class="ac-vi-form-option-title">Public</p>
			   <span class="ac-vi-form-option-des">Visible to anyone, on or off this site</span>
			</div>
			<span class="ac-vi-form-option-selected-fill"></span>
		   </div>
		   <div class="ac-vi-form-option-friends" data-type="friends">
			<span class="ac-vi-form-option-svg-bg"><svg   class="ionicon" viewBox="0 0 512 512"><path d="M336 256c-20.56 0-40.44-9.18-56-25.84-15.13-16.25-24.37-37.92-26-61-1.74-24.62 5.77-47.26 21.14-63.76S312 80 336 80c23.83 0 45.38 9.06 60.7 25.52 15.47 16.62 23 39.22 21.26 63.63-1.67 23.11-10.9 44.77-26 61C376.44 246.82 356.57 256 336 256zm66-88zM467.83 432H204.18a27.71 27.71 0 01-22-10.67 30.22 30.22 0 01-5.26-25.79c8.42-33.81 29.28-61.85 60.32-81.08C264.79 297.4 299.86 288 336 288c36.85 0 71 9 98.71 26.05 31.11 19.13 52 47.33 60.38 81.55a30.27 30.27 0 01-5.32 25.78A27.68 27.68 0 01467.83 432zM147 260c-35.19 0-66.13-32.72-69-72.93-1.42-20.6 5-39.65 18-53.62 12.86-13.83 31-21.45 51-21.45s38 7.66 50.93 21.57c13.1 14.08 19.5 33.09 18 53.52-2.87 40.2-33.8 72.91-68.93 72.91zM212.66 291.45c-17.59-8.6-40.42-12.9-65.65-12.9-29.46 0-58.07 7.68-80.57 21.62-25.51 15.83-42.67 38.88-49.6 66.71a27.39 27.39 0 004.79 23.36A25.32 25.32 0 0041.72 400h111a8 8 0 007.87-6.57c.11-.63.25-1.26.41-1.88 8.48-34.06 28.35-62.84 57.71-83.82a8 8 0 00-.63-13.39c-1.57-.92-3.37-1.89-5.42-2.89z"/></svg></span>
			<div>
			   <p class="ac-vi-form-option-title">Friends</p>
			   <span class="ac-vi-form-option-des">Visible only to your connections</span>
			</div>
			<span class="ac-vi-form-option-selected-fill"></span>
		   </div>
		   <div class="ac-vi-form-option-onlyme" data-type="onlyme">
			<span class="ac-vi-form-option-svg-bg"><svg viewBox="0 0 30 30"><g id="surface67244366"><path style=" stroke:none;fill-rule:nonzero;fill-opacity:1;" d="M 15 2 C 11.144531 2 8 5.144531 8 9 L 8 11 L 6 11 C 4.894531 11 4 11.894531 4 13 L 4 25 C 4 26.105469 4.894531 27 6 27 L 24 27 C 25.105469 27 26 26.105469 26 25 L 26 13 C 26 11.894531 25.105469 11 24 11 L 22 11 L 22 9 C 22 5.273438 19.035156 2.269531 15.355469 2.074219 C 15.242188 2.027344 15.121094 2.003906 15 2 Z M 15 4 C 17.773438 4 20 6.226562 20 9 L 20 11 L 10 11 L 10 9 C 10 6.226562 12.226562 4 15 4 Z M 15 4 "/></g></svg></span>
			<div>
			  <p class="ac-vi-form-option-title">Only me</p>
			   <span class="ac-vi-form-option-des">Visible only to you</span>
			</div>
			<span class="ac-vi-form-option-selected-fill"></span>
		   </div>
		   <div class="ac-vi-form-option-group">
			<span class="ac-vi-form-option-svg-bg">	<svg viewBox="0 0 80.13 80.13"><path d="M48.355,17.922c3.705,2.323,6.303,6.254,6.776,10.817c1.511,0.706,3.188,1.112,4.966,1.112   c6.491,0,11.752-5.261,11.752-11.751c0-6.491-5.261-11.752-11.752-11.752C53.668,6.35,48.453,11.517,48.355,17.922z M40.656,41.984   c6.491,0,11.752-5.262,11.752-11.752s-5.262-11.751-11.752-11.751c-6.49,0-11.754,5.262-11.754,11.752S34.166,41.984,40.656,41.984   z M45.641,42.785h-9.972c-8.297,0-15.047,6.751-15.047,15.048v12.195l0.031,0.191l0.84,0.263   c7.918,2.474,14.797,3.299,20.459,3.299c11.059,0,17.469-3.153,17.864-3.354l0.785-0.397h0.084V57.833   C60.688,49.536,53.938,42.785,45.641,42.785z M65.084,30.653h-9.895c-0.107,3.959-1.797,7.524-4.47,10.088   c7.375,2.193,12.771,9.032,12.771,17.11v3.758c9.77-0.358,15.4-3.127,15.771-3.313l0.785-0.398h0.084V45.699   C80.13,37.403,73.38,30.653,65.084,30.653z M20.035,29.853c2.299,0,4.438-0.671,6.25-1.814c0.576-3.757,2.59-7.04,5.467-9.276   c0.012-0.22,0.033-0.438,0.033-0.66c0-6.491-5.262-11.752-11.75-11.752c-6.492,0-11.752,5.261-11.752,11.752   C8.283,24.591,13.543,29.853,20.035,29.853z M30.589,40.741c-2.66-2.551-4.344-6.097-4.467-10.032   c-0.367-0.027-0.73-0.056-1.104-0.056h-9.971C6.75,30.653,0,37.403,0,45.699v12.197l0.031,0.188l0.84,0.265   c6.352,1.983,12.021,2.897,16.945,3.185v-3.683C17.818,49.773,23.212,42.936,30.589,40.741z"></path></svg></span>
			<div>
			  <p class="ac-vi-form-option-title">Post in Group</p>
			   <span class="ac-vi-form-option-des">Visible to members of a group</span>
			</div>
			<span class="ac-vi-form-option-selected-fill"></span>
		   </div>
		 </div>
	       </div>
	    </div>`;
  return markup;
}

function markupPostFormGroups(groups) {
  return `${groups
    .map(
      (cur) => `
		 <div class="ac-vi-group-item" data-id="${cur.id}">
		    <!-- <img src="" alt="" /> -->      
		    <p class="ac-vi-group-label">${cur.dom.label}</p>
		    <span class="ac-vi-group-select"></span>
		 </div>
		`
    )
    .join(" ")}`;
}

function activityGroupMarkup(groups) {
  const markup = `
	<div class="ac-group-main">
	   <div class="ac-group-header">
		<p>Select a group</p>
		<span class="close-popup">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
					<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
				</svg>
		</span>
	   </div>
	   <div class="ac-group-search">
		<input class="ac-vi-group-search-input" 
		type="text" placeholder="Search groups" />
		<svg  viewBox="0 0 48 48"><path d="m40.8994141 39.4853516-7.8127441-7.8127441c2.3978882-2.734375 3.7209473-6.1942749 3.7209473-9.8649902 0-4.0068359-1.5605469-7.7734375-4.3935547-10.6064453s-6.5996094-4.3935547-10.6064453-4.3935547-7.7734375 1.5605469-10.6064453 4.3935547-4.3935547 6.5996094-4.3935547 10.6064453 1.5605469 7.7734375 4.3935547 10.6064453 6.5996094 4.3935547 10.6064453 4.3935547c3.6707153 0 7.1306152-1.3230591 9.8649902-3.7209473l7.8127441 7.8127441c.1953125.1953125.4511719.2929688.7070313.2929688s.5117188-.0976563.7070313-.2929688c.3906249-.390625.3906249-1.0234375-.0000001-1.4140625zm-28.2841797-8.4853516c-2.4550781-2.4555664-3.8076172-5.7202148-3.8076172-9.1923828s1.3525391-6.7368164 3.8076172-9.1923828c2.4555664-2.4550781 5.7202148-3.8076172 9.1923828-3.8076172s6.7368164 1.3525391 9.1923828 3.8076172c2.4550781 2.4555664 3.8076172 5.7202148 3.8076172 9.1923828s-1.3525391 6.7368164-3.8076172 9.1923828c-2.4555664 2.4550781-5.7202148 3.8076172-9.1923828 3.8076172s-6.7368164-1.3525391-9.1923828-3.8076172z"></path></svg>
	   </div>
	   <div class="ac-group-lists">
	     ${markupPostFormGroups(groups)}
	   </div>
	   <div class="ac-group-footer">
	      <span class="ac-group-back">Back</span>
	      <span class="ac-group-save">Save</span>
	   </div>
	</div>
	`;

  return markup;
}

function closePostVisibilityPopup(formDom) {
  const visibilityEl = formDom.querySelector(".ac-vi-form-pop-main");
  const postFormEl = formDom.querySelector("#whats-new-form");

  visibilityEl.style.display = "none";
  postFormEl.style.display = "block";
}

function setPostVisibility(formDom, visibilityType) {
  const hiddenVisisbilityEl = formDom.querySelector(
    "#mf-activity-accessibility"
  );
  if (!hiddenVisisbilityEl)
    return console.log(new Error("no activity visibility el found"));

  hiddenVisisbilityEl.value = visibilityType;
}

function setInisialPostViTypeInPopup(formDom) {
  const option = formDom.querySelector(".ac-vi-form-options");
  Array.from(option.children).forEach((cur) =>
    cur.classList.remove("ac-vi-form-active")
  );
  const viType = formDom.querySelector("#mf-activity-accessibility").value;
  const activeEl = option.querySelector(`[data-type="${viType}"]`);

  if (!activeEl)
    return console.log(new Error("no visibility is active!! Thats weird!"));
  activeEl.classList.add("ac-vi-form-active");
}

function resetGroupAndViType(formDom) {
  //reset group
  const haveGroup = formDom.querySelector("#whats-new-post-in");
  if (!haveGroup) return;
  const groups = haveGroup.children;
  if (groups.length) {
    for (const group of groups) {
      group.removeAttribute("selected");
    }
    groups[0].setAttribute("selected", "selected");
  }
  //reset activity visibility
  formDom.querySelector("#mf-activity-accessibility").value = "public";
  setViMarkup(formDom, "public");
}

function setViMarkup(formDom, viType) {
  const markup = `
	${visibilityPostFormData.find((cur) => cur.vi == viType).svg}
	<span>${viType}</span>`;
  formDom.querySelector("#visibility-handler").innerHTML = markup;
}

function setGroupViMarkup(formDom, label) {
  const con = formDom.querySelector("#visibility-handler");
  con.innerHTML = `
	<div class="group-ac-vi-active">
	   <!-- <img src="" alt="" /> -->
	   <svg viewBox="0 0 80.13 80.13"><path d="M48.355,17.922c3.705,2.323,6.303,6.254,6.776,10.817c1.511,0.706,3.188,1.112,4.966,1.112   c6.491,0,11.752-5.261,11.752-11.751c0-6.491-5.261-11.752-11.752-11.752C53.668,6.35,48.453,11.517,48.355,17.922z M40.656,41.984   c6.491,0,11.752-5.262,11.752-11.752s-5.262-11.751-11.752-11.751c-6.49,0-11.754,5.262-11.754,11.752S34.166,41.984,40.656,41.984   z M45.641,42.785h-9.972c-8.297,0-15.047,6.751-15.047,15.048v12.195l0.031,0.191l0.84,0.263   c7.918,2.474,14.797,3.299,20.459,3.299c11.059,0,17.469-3.153,17.864-3.354l0.785-0.397h0.084V57.833   C60.688,49.536,53.938,42.785,45.641,42.785z M65.084,30.653h-9.895c-0.107,3.959-1.797,7.524-4.47,10.088   c7.375,2.193,12.771,9.032,12.771,17.11v3.758c9.77-0.358,15.4-3.127,15.771-3.313l0.785-0.398h0.084V45.699   C80.13,37.403,73.38,30.653,65.084,30.653z M20.035,29.853c2.299,0,4.438-0.671,6.25-1.814c0.576-3.757,2.59-7.04,5.467-9.276   c0.012-0.22,0.033-0.438,0.033-0.66c0-6.491-5.262-11.752-11.75-11.752c-6.492,0-11.752,5.261-11.752,11.752   C8.283,24.591,13.543,29.853,20.035,29.853z M30.589,40.741c-2.66-2.551-4.344-6.097-4.467-10.032   c-0.367-0.027-0.73-0.056-1.104-0.056h-9.971C6.75,30.653,0,37.403,0,45.699v12.197l0.031,0.188l0.84,0.265   c6.352,1.983,12.021,2.897,16.945,3.185v-3.683C17.818,49.773,23.212,42.936,30.589,40.741z"></path></svg>
	   <span>${label}</span>
	</div>
	`;
}

function closeGroupPopup(formDom) {
  //close group
  const group = formDom.querySelector(".ac-group-main");
  if (group) group.remove();
  //open visibility
  formDom.querySelector(".ac-vi-form-pop-main").style.display = "block";
  //set inisial visibility
  setInisialPostViTypeInPopup(formDom);
}

function handleGroupSearchInPopupForm(e, formDom, groups) {
  console.log(groups, e, formDom);
  //get input value
  const search = e.target.value.trim().toLowerCase();
  if (!search) {
    // render all groups
    formDom.querySelector(".ac-group-lists").innerHTML =
      markupPostFormGroups(groups);
    return;
  }
  //find matches group
  const newGroups = Array.from(groups).filter((cur) =>
    cur.dom.label.trim().toLowerCase().startsWith(search)
  );
  console.log(newGroups);
  // render new groups
  formDom.querySelector(".ac-group-lists").innerHTML =
    markupPostFormGroups(newGroups);
}

function handleGroupSelect(item, formDom) {
  const allGroups = item.parentElement.children;
  Array.from(allGroups).forEach((cur) => cur.classList.remove("active"));
  item.classList.add("active");
}

function handleGroupSelectSaveClick(formDom) {
  //select cur selectd group
  const selectedGroup = formDom.querySelector(".ac-vi-group-item.active");

  const hiddenGroupEl = formDom.querySelector(
    `#whats-new-post-in option[value="${selectedGroup.dataset.id}"]`
  );
  if (!hiddenGroupEl) return;
  //remove all other selectd el from hiddenGroupEl
  const hidenEls = formDom.querySelectorAll("#whats-new-post-in option");
  for (const hidenEl of hidenEls) {
    hidenEl.removeAttribute("selected");
  }
  //add new selected el
  hiddenGroupEl.setAttribute("selected", "selected");
  //add markup to post form to indicate group is selected
  setGroupViMarkup(formDom, hiddenGroupEl.innerText);
  //close popup
  closeGroupPopup(formDom);
  closePostVisibilityPopup(formDom);
}

//controller
function handleActivityPostFormPublickBtnClick(formDom) {
  const markup = activityVisibilityMarkup();
  const form = formDom.querySelector("#whats-new-form");
  //hide the form
  form.style.display = "none";
  //remove previews markup
  const prePop = formDom.querySelector(".ac-vi-form-pop-main");
  if (prePop) prePop.remove();
  //add new markup
  formDom.insertAdjacentHTML("beforeend", markup);
  // add listener
  addListernerToVisibilityPopup(formDom);
  //set inisial visibility
  setInisialPostViTypeInPopup(formDom);
}
function addListernerToVisibilityPopup(formDom) {
  const option = formDom.querySelector(".ac-vi-form-options");
  const options = option.children;

  for (i = 0; i < options.length; i++) {
    if (i < 3) {
      const index = i;
      options[i].onclick = (e) => {
        handleActivityVisibilityClick(e, options[index], options, formDom);
      };
    } else {
      const index = i;
      options[i].onclick = (e) => {
        handleActivityVisibilityGroupClick(e, options[index], options, formDom);
      };
    }
  }

  formDom.querySelector(".close-popup").onclick = (e) => {
    closePostVisibilityPopup(formDom);
    toggleActivityPostFormPopup("close");
  };
}

function handleActivityVisibilityClick(e, clickEl, optionsEl, formDom) {
  //remove other active el
  Array.from(optionsEl).forEach((cur) =>
    cur.classList.remove("ac-vi-form-active")
  );
  //add active to clicked el
  clickEl.classList.add("ac-vi-form-active");
  //set value
  const viType = clickEl.dataset.type;
  setPostVisibility(formDom, viType);
  //set visibility in post form
  setViMarkup(formDom, viType);
  //close visibility popup
  closePostVisibilityPopup(formDom);
}

function addListenerToAcViGroupPopup(formDom) {
  const popup = formDom.querySelector(".ac-group-main");
  //console.log(popup);
  if (!popup) return console.log(new Error("group popup is not there."));

  popup.onclick = (e) => {
    if (e.target.matches(".ac-group-back")) {
      closeGroupPopup(formDom);
      return;
    }

    if (e.target.closest(".ac-vi-group-item")) {
      const item = e.target.closest(".ac-vi-group-item");
      handleGroupSelect(item, formDom);
    }

    if (e.target.matches(".ac-group-save")) {
      handleGroupSelectSaveClick(formDom);
    }

    if (e.target.closest(".close-popup")) {
      closeGroupPopup(formDom);
      closePostVisibilityPopup(formDom);
      toggleActivityPostFormPopup("close");
    }
  };

  const groups = getgroups(formDom);
  popup.querySelector(".ac-vi-group-search-input").oninput = (e) => {
    handleGroupSearchInPopupForm(e, formDom, groups);
  };
}

function handleActivityVisibilityGroupClick(e, clickEl, optionsEl, formDom) {
  //remove other active el
  Array.from(optionsEl).forEach((cur) =>
    cur.classList.remove("ac-vi-form-active")
  );
  //add active to clicked el
  clickEl.classList.add("ac-vi-form-active");
  //hide vi popup
  formDom.querySelector(".ac-vi-form-pop-main").style.display = "none";
  //close prePopup
  const prePop = formDom.querySelector(".ac-group-main");
  if (prePop) prePop.remove();
  //open group popup
  formDom.insertAdjacentHTML(
    "beforeend",
    activityGroupMarkup(getgroups(formDom))
  );
  //add necessary event listener
  addListenerToAcViGroupPopup(formDom);
}

function activityPostFormEventHandler(e, formDom) {
  const publicBtnClicked = e.target.closest("#visibility-handler");
  if (publicBtnClicked) {
    handleActivityPostFormPublickBtnClick(formDom);
    return;
  }
  if (e.target.closest(".whats-new-close")) {
    e.preventDefault();
    toggleActivityPostFormPopup("close");
    resetActivityForm();
  }
}

function ActivityPostFormInit() {
  //select activity popup form
  const activityPostFormDom = document.getElementById(
    "bp-nouveau-activity-form"
  );
  const activityPostShowCaseForm = document.querySelector(
    ".ac-post-form-showcase"
  );
  if (!activityPostFormDom) return;

  //console.log(getgroups(activityPostFormDom));
  const visibility = getVisibility(activityPostFormDom);
  //console.log(visibility);

  renderDefaultVisibility(visibility[0].dom.label, activityPostFormDom);

  activityPostFormDom.addEventListener("click", (e) => {
    activityPostFormEventHandler(e, activityPostFormDom);
  });

  activityPostShowCaseForm.addEventListener("click", (e) => {
    toggleActivityPostFormPopup("open");
  });
}

window.addEventListener("load", () => {
  ActivityPostFormInit();
});

/****************
 Activity popup script end here
 *****************/

/****************
 Activity edite script start here
 *****************/
//this 3 variable keep track that when post is submit
//it is submited for edite or createing a new post
let mf_activity_edite_is_delete_activity = false;
let mf_activity_id_of_current_editeing_activity = false;
let mf_activity_current_editing_activity_dom = false;

class ActivityEditeControler {
  constructor() {
    this.postFormDom = document.querySelector("#bp-nouveau-activity-form");
    this.addListenerToEditeActivityBtn();
  }

  addListenerToEditeActivityBtn() {
    const activityStremEl = document.querySelector("#activity-stream");
    if (!activityStremEl) return;

    activityStremEl.addEventListener("click", (e) => {
      const editeActivityBtn = e.target.closest(".edite-activity");
      if (editeActivityBtn) {
        this.handleActivityEditeBtnClick(e);
      }
    });
  }

  async handleActivityEditeBtnClick(e) {

    const canEdite = e.target.closest(".activity-item").dataset.canedite;

    if(canEdite == "false") return;
    //open post form popup
    this.openPostFormPopup();
    //get id of the activity
    const id = e.target.closest(".activity-item").dataset.bpActivityId;
    await this.getActivity(id);
    //set activity visibility
    this.setActivityVisibility();
    //set activity group
    this.setActivityGroup();
    //set activity content
    this.setActivityContent();
    //set activity images
    this.setActivityImages();
    //set data to edite activity
    this.setEditeActivityData(e);
    //remove loader
    this.removeLoader();
  }

  openPostFormPopup() {
    this.addLoader();
    //change post activity btn text
    this.postFormDom.querySelector("#aw-whats-new-submit").value =
      "Update Post";
    toggleActivityPostFormPopup("open");
  }

  setEditeActivityData(e) {
    mf_activity_edite_is_delete_activity = true;
    mf_activity_id_of_current_editeing_activity =
      this.activity.activities[0].id;
    const el = e.target.closest(".activity-item");
    mf_activity_current_editing_activity_dom = el;
  }

  addLoader() {
    //add loader
    const form = this.postFormDom.querySelector("#whats-new-form");
    if (!form) return;
    form.classList.add("submitting");
    this.postFormDom
      .querySelector("form")
      .insertAdjacentHTML(
        "beforeend",
        `<svg class="sharing-spinner" viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle></svg>`
      );
  }

  removeLoader() {
    //remove loader
    const form = this.postFormDom.querySelector("#whats-new-form");
    if (!form) return;
    form.classList.remove("submitting");
    this.postFormDom.querySelector(".sharing-spinner").remove();
  }

  async getActivity(id) {
    const res = await jQuery.ajax({
      type: "post",
      url: mf_local.ajaxurl,
      data: {
        activity_id: id,
        action: "mf_get_activity_by_id",
      },
    });
    console.log(res);

    this.activity = res;
    //console.log(this.activity);
  }

  setActivityVisibility() {
    setPostVisibility(this.postFormDom, this.activity.activity_visibility);
    setViMarkup(this.postFormDom, this.activity.activity_visibility);
  }

  setActivityGroup() {
    const isGroup = this.activity.activities[0].component;
    if (isGroup !== "groups") return;

    const hiddenGroupEl = this.postFormDom.querySelector(
      `#whats-new-post-in option[value="${this.activity.activities[0].item_id}"]`
    );
    if (!hiddenGroupEl) return;
    //add new selected el
    hiddenGroupEl.setAttribute("selected", "selected");
    //add markup to post form to indicate group is selected
    setGroupViMarkup(this.postFormDom, hiddenGroupEl.innerText);
  }

  setActivityContent() {
    this.postFormDom.querySelector("#th-bp-whats-new").innerHTML =
      this.activity.activities[0].content.replace(/\\/g, "").replace(/\n/g,"<br>");
  }

  setActivityImages() {
    if (!this.activity.meta.length) return;

    const markup = `${this.activity.meta
      .map((cur) => this.previewMarkup(cur))
      .join(" ")}`;

    //add ids to hidden input so new image can save
    this.postFormDom.querySelector("#whats-new-post-media").value =
      this.activity.meta.map((cur) => cur.attachment_id).join(", "); //keep space after ,

    const preCon = this.postFormDom.querySelector(".whats-new-previewer");
    preCon.classList.add("previewer-toggle");
    preCon.insertAdjacentHTML("afterbegin", markup);
  }

  previewMarkup(img) {
    const uid = Date.now() + Math.round(Math.random() * 20);
    const imgMediaMarkup = (url) => `<img src="${url}">`;
    const videoMediaMarkup = (url) => `<video src="${url}" alt="video" />`;
    //const applicationMediaMarkup = (url) =>

    return `<p class="media-uploading done image/png" id="${uid}">
	      ${img.thumb ? imgMediaMarkup(img.thumb[0]) : ""}
	       <span class="remove-media" data-media-id="${uid}"
	       data-attachment-id="${img.attachment_id}">✕</span>
	    </p>`;
  }
}
window.addEventListener("load", () => {
  new ActivityEditeControler();
});

/****************
 Activity edite script end here
 *****************/

function resetActivityForm() {
  jQuery("#whats-new-form").removeClass("submitting");
  jQuery("#whats-new-content").hide(200);
  jQuery("#whats-new-attachments").hide();
  jQuery(".whats-new-header-media-section").show(200);
  jQuery(".whats-new-intro-header").css({
    "font-size": "13px",
    "font-weight": "500",
  });
  jQuery(".whats-new-intro-header").show();
  //removes texts
  jQuery(".advanced-th-bp-activity-form").text("");
  jQuery(".media-uploading").remove();
  jQuery(".url-scrap-view").remove();
  jQuery("#whats-new-post-url-preview").val("");
  jQuery("#whats-new-post-media").val("");
}

jQuery(document).ready(function () {
  jQuery(document).on("click", "#more-nav > li > a", function (e) {
    e.preventDefault();
    jQuery(this).parent().toggleClass("more-nav-open");
  });

  if (jQuery("#th_bbp_reply").length) {
    var quillEditor = new Quill("#th_bbp_reply", {
      modules: {
        toolbar: [
          [{ header: [1, 2, 3, 4, false] }],
          ["bold", "italic", "underline"],
          ["link", "blockquote", "code-block", "image"],
          [{ list: "ordered" }, { list: "bullet" }],
        ],
      },
      placeholder: "Your topic description...",
      theme: "snow", // or 'bubble'
    });
  }
  // Dark and light version switcher
  jQuery( document ).on("click", ".mode-switcher", function(e){
    var _that = jQuery(this);
    var current_theme = _that.attr("data-switcher-mode");
    if( current_theme == "light" ){
      jQuery("body").addClass("metafans-dark");
      _that.attr("data-switcher-mode", "dark");
      _that.find("span.moon").addClass("hidden").removeClass("active");
      _that.find("span.sun").addClass("active").removeClass("hidden");
    }else if( current_theme == "dark" ){
      jQuery("body").removeClass("metafans-dark");
      _that.attr("data-switcher-mode", "light");
      _that.find("span.sun").addClass("hidden").removeClass("active");
      _that.find("span.moon").addClass("active").removeClass("hidden");
    }
  });
  // BBPRESS submit reply ajax
  jQuery(document).on("click", "#th_bbp_reply_submit", function (e) {
    e.preventDefault();
    var that = jQuery(this);
    that.text("Please Wait...");
    that.attr("disabled", true);
    var data = jQuery(".th-bbpress-reply-form").serializeArray();
    var text = quillEditor.root.innerHTML;
    data[data.length] = { name: "bbp_reply_content", value: text };
    var newData = {};
    data.filter(function (item) {
      newData[item.name] = item.value;
    });

    console.log(newData);
    jQuery.ajax({
      url: Metafans_JS.ajaxurl,
      type: "POST",
      data: {
        action: "th_bbp_new_reply",
        data: newData,
      },
      success: function (res) {
        console.log(res);
        if (res.errors) {
          jQuery(".th_bpp_reply_messages").html(
            '<span class="errors">' + res.errors.toString() + "</span>"
          );
          that.attr("disabled", false);
        } else {
          jQuery(".th_bpp_reply_messages").html(
            '<span class="success">' + res.success["text"] + "</span>"
          );
          window.location.href = res.success["goto"];
        }
        that.text("Submit");
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
      },
    });
  });

  jQuery(document).on(
    "click",
    ".activity-inner a:not(.media-popup-thumbnail)",
    function (e) {
      e.preventDefault();
      var url = jQuery(this).attr("href");
      window.open(url);
    }
  );

  jQuery("#bold_btn").on("click", function () {
    //jQuery('#textarea, #textarea-show').toggleClass('bold');
    document.execCommand("bold");
  });
  jQuery("#italic_btn").on("click", function () {
    //jQuery('#textarea, #textarea-show').toggleClass('italic');
    document.execCommand("italic");
  });

  jQuery(document).mouseup(function (e) {
    var container = jQuery("#whats-new-form");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      if (!jQuery(".whats-new-previewer").has(".media-uploading")) {
        jQuery("#whats-new-content").hide(0);
        jQuery(".whats-new-header-media-section").show(0);
        jQuery("#whats-new-attachments").hide(0);
        jQuery(".whats-new-intro-header").css({
          "font-size": "13px",
          "font-weight": "500",
        });
        jQuery(".whats-new-intro-header").show(0);
      }
    }
  });
  jQuery(".advanced-th-bp-activity-form").on("input", function () {
    if (
          jQuery(".advanced-th-bp-activity-form").text().length > 0 ||
          document.querySelector("form .whats-new-live-preview")
       ) {
      jQuery("#aw-whats-new-submit").removeAttr("disabled");
    } else {
      document
        .getElementById("aw-whats-new-submit")
        .setAttribute("disabled", "disabled");
    }
  });
  jQuery(".advanced-th-bp-activity-form").bind("paste", function (e) {
    jQuery("#aw-whats-new-submit").removeAttr("disabled");
    e.preventDefault();
    var text = e.originalEvent.clipboardData.getData("text");
    // var text = (e.originalEvent || e).clipboardData.getData('text/plain');
    if (isURL(text)) {
      document.execCommand("insertHTML", false, text);
      if (jQuery(this).parent().find(".url-scrap-view").length == 0) {
        jQuery(this).after(
          '<div class="url-scrap-view loading"><svg class="sharing-spinner" viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="10" fill="none" stroke-width="3"></circle></svg></div>'
        );
      }
      jQuery.ajax({
        url: Metafans_JS.ajaxurl,
        type: "POST",
        data: {
          action: "tophive_bp_get_scrapped_html",
          url: text,
        },
        success: function (data) {
          console.log(data);
          jQuery(".url-scrap-view").html(data).removeClass("loading");
          jQuery("#whats-new-post-url-preview").val(text);
        },
      });
    } else {
      document.execCommand("insertHTML", false, text);
    }
  });
  function isURL(str) {
    var pattern = new RegExp(
      "^(https?:\\/\\/)?" + // protocol
        "((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|" + // domain name
        "((\\d{1,3}\\.){3}\\d{1,3}))" + // OR ip (v4) address
        "(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*" + // port and path
        "(\\?[;&a-z\\d%_.~+=-]*)?" + // query string
        "(\\#[-a-z\\d_]*)?$",
      "i"
    ); // fragment locator
    return !!pattern.test(str);
  }
  jQuery(
    "#whats-new-attachments p.image, #whats-new-attachments p.video, #whats-new-attachments p.documents"
  ).on("click", function () {
    jQuery(".whats-new-previewer").toggleClass("previewer-toggle");
  });
  // jQuery(".activity-soundcloud-embed iframe").on('load', function() {
  jQuery(".activity-soundcloud-embed iframe")
    .contents()
    .find(".widget")
    .css("border", "none");
  jQuery(".activity-soundcloud-embed iframe")
    .contents()
    .find(".g-background-default")
    .css("backgroundColor", "transparent");
  // });
});

jQuery(".activity-update-form").append("<h2>go pro</h2>");

/****************
 Toaster Notification starts
 *****************/
function setNotification(msgtype, message) {
  var notification_container = jQuery(".metafans-toaster-container");
  var notification_icon = notification_container.find(".type-icon");
  var notification_message = notification_container.find(".notification-msg");
  var icons = [
    {
      type: "success",
      icon: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>',
    },
    {
      type: "info",
      icon: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg>',
    },
    {
      type: "warning",
      icon: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>',
    },
    {
      type: "error",
      icon: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/></svg>',
    },
  ];
  var position = "right-bottom";
  var timeout = 3;
  var selected_icon = icons.find((icon) => icon.type == msgtype).icon;
  notification_container.removeClass("success error warning info");
  notification_container.addClass(msgtype);
  notification_icon.html(selected_icon);
  notification_message.html(message);
}
function openNotification(timeout) {
  var notification_container = jQuery(".metafans-toaster-container");
  notification_container.addClass("open");
  setTimeout(function () {
    notification_container.removeClass("open");
  }, timeout);
}
function showNotification(type, message) {
  setNotification(type, message);
  openNotification(5000);
}

jQuery(function () {
  jQuery(document).on("click", "button.popup-cancel", function (e) {
    e.preventDefault();
    jQuery(".metafans-alert-popup").removeClass("open");
  });

  jQuery(document).on("click", ".confirm-delete-activity", function (e) {
    e.preventDefault();
    console.log("deleting...");
    jQuery(".metafans-alert-popup").removeClass("open");
    var activity_id = jQuery(this).attr("data-id");
    var action_type = jQuery(this).attr("data-action");
    if (undefined !== activity_id || undefined !== action) {
      jQuery.ajax({
        url: Metafans_JS.ajaxurl,
        type: "POST",
        data: {
          action: "metafans_activity_delete",
          activity_id: activity_id,
          action_type: action_type,
        },
        success: function (data) {
          console.log(data);
          showNotification(data.response_type, data.response_msg);
          //remove the activity from dom after delete
          const deletedActivityEl = document.querySelector(
            `.activity-item[data-bp-activity-id="${activity_id}"]`
          );
          deletedActivityEl.remove();
        },
      });
    }
  });
  jQuery(document).on("click", ".th-bp-post-like-button a", function (e) {
    e.preventDefault();
    var _that = jQuery(this);
    var activityID = jQuery(this).data("id");
    var userID = jQuery(this).data("user");
    var nonce = jQuery(this).data("nonce");
    jQuery.ajax({
      url: Metafans_JS.ajaxurl,
      type: "POST",
      data: {
        action: "tophive_bp_likes_response",
        activity_id: activityID,
        userid: userID,
        security: nonce,
      },
      success: function (data) {
        console.log(data);
        _that.find(".like_icon").html(data.icon);
        _that.find(".like_link").html(data.text);
        _that.find(".like_count").html(data.likes);
      },
    });
  });
  jQuery(document).on(
    "click",
    ".th-bp-header-notification-container .th-bp-notif-logo",
    function (e) {
      e.preventDefault();
      jQuery(".th-bp-header-notification-container ul").toggleClass("show_dd");
    }
  );
  jQuery(document).on(
    "click",
    ".th-bp-header-messenger-container .th-bp-inbox-logo",
    function (e) {
      e.preventDefault();
      jQuery(".th-bp-header-messenger-container ul").toggleClass("show_dd");
    }
  );

  jQuery("#whats-new-form").on("submit", function (e) {
    var formData = jQuery("#whats-new-form").serializeArray();
    var text = jQuery("#th-bp-whats-new").text();
    var loading_icon =
      '<svg class="sharing-spinner" viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle></svg>';
    var urlPreview = jQuery("#whats-new-post-url-preview").val();
    let ht = jQuery("#th-bp-whats-new")
      .html()
      .replace(/<div>/g, "\n")
      .replace(/<\/div>/g, "")
      .replace(/<br>/g, "\n");
    const activityAccessibility = document.querySelector(
      "#mf-activity-accessibility"
    ).value;

    console.log(ht);
    formData.push(
      { name: "whats-new-post-content", value: ht },
      { name: "whats-new-post-url-preview", value: urlPreview }
    );
    var newData = {};
    formData.filter(function (item) {
      newData[item.name] = item.value;
    });
    //add activity accessibility to the newData object
    newData.activity_accessibility = activityAccessibility
      ? activityAccessibility
      : "public";

    console.log(newData);
    newData.is_delete_activity = mf_activity_edite_is_delete_activity;
    newData.activity_id = mf_activity_id_of_current_editeing_activity;
    jQuery.ajax({
      url: Metafans_JS.ajaxurl,
      type: "POST",
      data: {
        action: "th_bp_post_update",
        data: newData,
        nonce: newData._wpnonce_post_update,
      },
      beforeSend: function () {
        jQuery("#whats-new-form").addClass("submitting");
        jQuery("#whats-new-form").append(loading_icon);
      },
      success: function (res) {
        console.log(res);
        if (res.success) {
          jQuery("ul.activity-list").prepend(res.activity).hide().fadeIn();
          resetActivityForm();
          //if post submit from edite form then
          //remove the old activity dom element
          if (mf_activity_current_editing_activity_dom) {
            mf_activity_current_editing_activity_dom.remove();
            window.scrollTo({
              top: 100,
              left: 0,
              behavior: "smooth",
            });
          }
          //close activity form popup
          toggleActivityPostFormPopup("close");
        } else if (res.error) {
          jQuery("#whats-new-form").removeClass("submitting");
          alert(res.error);
        }
      },
    });
    return false;
  });
  jQuery(document).on(
    "click",
    "#whats-new-textarea .url-scrap-view .cross",
    function () {
      jQuery("#whats-new-post-url-preview").val("");
      jQuery("#whats-new-textarea .url-scrap-view").remove();

      if (
          jQuery(".advanced-th-bp-activity-form").text().length > 0 ||
          document.querySelector("form .whats-new-live-preview")
       ) {
      jQuery("#aw-whats-new-submit").removeAttr("disabled");
    } else {
      document
        .getElementById("aw-whats-new-submit")
        .setAttribute("disabled", "disabled");
    }
    }
  );
  jQuery(document).on("change", ".comment-upload-media", function () {
    var activity_id = jQuery(this).data("id");
    commentImagePreview(this, activity_id);
    console.log(activity_id);
  });
  jQuery(document).on("change", "#upload-media", function () {
    imagesPreview(this, "div.whats-new-previewer");
  });
  var commentImagePreview = function (input, id) {
    if (input.files) {
      var file = input.files[0];
      var fileName = input.files[0].name;
      var formData = new FormData();
      var uniqid = Date.now();
      formData.append("action", "activity_upload");
      formData.append("file_name", fileName);
      formData.append("upload_file", file);
      jQuery.ajax({
        url: Metafans_JS.ajaxurl,
        type: "POST",
        dataType: "json",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
          jQuery(".comments-media-preview-" + id).addClass("media-uploading");
          console.log("UPloading");
        },
        success: function (data) {
          console.log(data);
          jQuery(".comments-media-preview-" + id)
            .addClass("done " + data.type)
            .html(data.html); // use append if multiple uploads needed
          jQuery(".comments-media-preview-" + id).append(
            '<span class="remove-comment-media" data-activity-id="' +
              id +
              '" data-attachment-id="' +
              data.id +
              '">✕</span>'
          );
          jQuery("#comment-media-url-" + id).val(data.url);
        },
      });
    }
  };
  jQuery(document).on("click", ".remove-comment-media", function () {
    var attachment_id = jQuery(this).attr("data-attachment-id");
    var activity_id = jQuery(this).attr("data-activity-id");
    jQuery.ajax({
      url: Metafans_JS.ajaxurl,
      type: "post",
      data: {
        action: "th_bp_remove_media",
        att_id: attachment_id,
      },
      beforeSend: function () {
        jQuery(".comments-media-preview-" + activity_id)
          .fadeOut(200)
          .removeClass("media-uploading done");
      },
      success: function (response) {
        if (response !== null) {
          jQuery(".comments-media-preview-" + activity_id)
            .html("")
            .fadeIn(100);
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
      },
    });
  });
  var imagesPreview = function (input, placeToInsertImagePreview) {
    var ids = jQuery("#whats-new-post-media").val();
    if (input.files) {
      var file = input.files[0];
      var fileName = input.files[0].name;
      var formData = new FormData();
      var uniqid = Date.now();
      formData.append("action", "activity_upload");
      formData.append("file_name", fileName);
      formData.append("upload_file", file);
      jQuery.ajax({
        url: Metafans_JS.ajaxurl,
        type: "POST",
        dataType: "json",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
          jQuery(".previewer-uploader").before(
            '<p class="media-uploading" id="' + uniqid + '"></p>'
          );
        },
        success: function (data) {
          console.log(data);
          jQuery("#" + uniqid)
            .addClass("done " + data.type)
            .append(data.html);
          jQuery("#" + uniqid).append(
            '<span class="remove-media" data-media-id="' +
              uniqid +
              '" data-attachment-id="' +
              data.id +
              '">✕</span>'
          );
          if (ids == "") {
            var allids = data.id;
          } else {
            var allids = ids + ", " + data.id;
          }
          jQuery("#whats-new-post-media").val(allids);
          jQuery("#aw-whats-new-submit").removeAttr("disabled");
        },
      });
    }
  };
  jQuery(document).on("click", ".remove-media", function () {
    var attachment_id = jQuery(this).attr("data-attachment-id");
    var media_id = jQuery(this).attr("data-media-id");
    var ids = jQuery("#whats-new-post-media").val();

    jQuery.ajax({
      url: Metafans_JS.ajaxurl,
      type: "post",
      data: {
        action: "th_bp_remove_media",
        att_id: attachment_id,
      },
      beforeSend: function () {
        jQuery("#" + media_id).fadeOut(200);
        var newIds = removeValue(ids, media_id, ",");
        jQuery("#whats-new-post-media").val(newIds);
      },
      success: function (response) {
        if (response !== null) {
          jQuery("#" + media_id).remove();
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
      },
    });
  });
  var removeValue = function (list, value, separator) {
    separator = separator || ",";
    var values = list.split(separator);
    for (var i = 0; i < values.length; i++) {
      if (values[i] == value) {
        values.splice(i, 1);
        return values.join(separator);
      }
    }
    return list;
  };
  jQuery(document).mouseup(function (e) {
    var notifier = jQuery(".th-bp-header-notification-container ul.show_dd");
    if (!notifier.is(e.target) && notifier.has(e.target).length === 0) {
      notifier.removeClass("show_dd");
    }
    var messenger = jQuery(".th-bp-header-messenger-container ul.show_dd");
    if (!messenger.is(e.target) && messenger.has(e.target).length === 0) {
      messenger.removeClass("show_dd");
    }
  });

  jQuery(".header-social_search_box-item input.search-field").on(
    "blur input",
    function (event) {
      var text = this.value.trim();
      var _that = jQuery(this);
      if (text !== "") {
        jQuery(this)
          .parents()
          .find(".search-box-result")
          .slideDown(400, function () {
            //ajax
            jQuery.ajax({
              url: Metafans_JS.ajaxurl,
              type: "post",
              data: {
                action: "th_bp_bb_social_search",
                text: text,
              },
              success: function (response) {
                _that.parents().find(".search-box-result").html(response);
              },
              error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
              },
            });
          });
      } else {
        jQuery(this)
          .parents()
          .find(".search-box-result")
          .slideUp(200, function () {
            jQuery(this).parents().find(".search-box-result").html(text);
          });
      }
    }
  );
  jQuery(document).on("click", ".media-popup-thumbnail", function (e) {
    e.preventDefault();
    var current_slider = jQuery(this).closest(".bp-image-single").attr("id");
    var full_url = jQuery(this).attr("href");

    setCurrentId(current_slider);
    jQuery(".th-media-viewer-container").addClass("show");
    setTheImage(full_url);

    var media_id = jQuery(this).attr("data-id");
    var activity_id = jQuery(this).attr("data-activity");
    setMediaAuthor(media_id, activity_id);
    setComments(media_id, activity_id);
  });
  jQuery(".th-media-viewer-container .close").on("click", function (e) {
    e.preventDefault();
    jQuery(".th-media-viewer-container").removeClass("show");
  });
  jQuery(document).on(
    "click",
    ".image-viewer-next-prev .img-prev",
    function () {
      var url = jQuery(this).data("prev");
      var current_id = jQuery(this).attr("data-current-id");
      SliderRotator(url, current_id, "prev");
    }
  );
  jQuery(document).on(
    "click",
    ".image-viewer-next-prev .img-next",
    function () {
      var url = jQuery(this).data("next");
      var current_id = jQuery(this).attr("data-current-id");
      SliderRotator(url, current_id, "next");
    }
  );
  function SliderRotator(url, current_id, type) {
    if (type === "prev") {
      var idd = getPrevImageId(current_id);
    }
    if (type === "next") {
      var idd = getNextImageId(current_id);
    }
    var mid = getMediaId(idd);
    var aid = getActivityId(idd);
    var img_url = getImageUrl(idd);
    console.log(img_url);
    if (img_url !== undefined) {
      setCurrentId(idd);
      setTheImage(getImageUrl(idd));
      setComments(mid, aid);
      setMediaAuthor(mid, aid);
    }
  }
  function setMediaAuthor(media_id, activity_id) {
    jQuery.ajax({
      url: Metafans_JS.ajaxurl,
      type: "post",
      data: {
        action: "th_bp_media_author",
        media_id: media_id,
        activity_id: activity_id,
      },
      success: function (response) {
        jQuery(
          ".th-media-viewer-container .th-media-comments .author_section"
        ).html(response);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
      },
    });
  }
  function setCurrentId(id) {
    jQuery(".image-viewer-next-prev span").attr("data-current-id", id);
  }
  function getNextImageId(current_id) {
    if (current_id < 0) {
      current_id == 0;
    }
    var next_id = +current_id + 1;
    var imageCount = getTotalImages();
    console.log(imageCount);
    if (next_id <= 0) {
      return 1;
    } else if (next_id >= imageCount) {
      return imageCount;
    } else {
      return next_id;
    }
  }
  function getImageUrl(id) {
    return jQuery(".bp-image-single#" + id)
      .find(".media-popup-thumbnail")
      .attr("href");
  }
  function getMediaId(id) {
    return jQuery(".bp-image-single#" + id)
      .find(".media-popup-thumbnail")
      .attr("data-id");
  }
  function getActivityId(id) {
    return jQuery(".bp-image-single#" + id)
      .find(".media-popup-thumbnail")
      .attr("data-activity");
  }
  function getPrevImageId(current_id) {
    if (current_id < 0) {
      current_id == 0;
    }
    var prev_id = +current_id - 1;
    var imageCount = getTotalImages();
    if (prev_id <= 0) {
      return 1;
    } else if (prev_id >= imageCount) {
      return imageCount;
    } else {
      return prev_id;
    }
  }
  function getTotalImages() {
    return jQuery(".bp-image-single").length;
  }
  function setTheImage(url) {
    var image_html = "<img src=" + url + ' alt="image_popup"/>';
    jQuery(".th-media-viewer-container .th-media-view").html(image_html);
  }

  jQuery(document).on(
    "click",
    ".th-bp-media-comment-button .bp-media-reactions",
    function (e) {
      e.preventDefault();
      var media_id = jQuery(this).attr("data-media-id");
      var activity_id = jQuery(this).attr("data-activity-id");

      postCommentReaction("love", media_id, activity_id);
    }
  );

  jQuery(document).on(
    "click",
    ".th-bp-post-like-button .reaction_icons img",
    function () {
      if (!Metafans_JS.logged_in) {
        return;
      }
      var _that = jQuery(this);
      var reaction_type = _that.attr("data-type");
      var activity_id = _that.attr("data-activity-id");

      if (reaction_type === "haha") {
        _that
          .parents(".th-bp-post-like-button")
          .find("a")
          .attr("data-reaction", "")
          .attr("data-reaction", reaction_type)
          .html(
            '<img src="' + Metafans_JS.haha_img + '" /> ' + Metafans_JS.haha_text
          );
      } else if (reaction_type === "wow") {
        _that
          .parents(".th-bp-post-like-button")
          .find("a")
          .attr("data-reaction", "")
          .attr("data-reaction", reaction_type)
          .html(
            '<img src="' + Metafans_JS.wow_img + '" /> ' + Metafans_JS.wow_text
          );
      } else if (reaction_type === "angry") {
        _that
          .parents(".th-bp-post-like-button")
          .find("a")
          .attr("data-reaction", "")
          .attr("data-reaction", reaction_type)
          .html(
            '<img src="' +
              Metafans_JS.angry_img +
              '" /> ' +
              Metafans_JS.angry_text
          );
      } else if (reaction_type === "cry") {
        _that
          .parents(".th-bp-post-like-button")
          .find("a")
          .attr("data-reaction", "")
          .attr("data-reaction", reaction_type)
          .html(
            '<img src="' + Metafans_JS.cry_img + '" /> ' + Metafans_JS.cry_text
          );
      } else if (reaction_type === "love") {
        _that
          .parents(".th-bp-post-like-button")
          .find("a")
          .attr("data-reaction", "")
          .attr("data-reaction", reaction_type)
          .html(
            '<img src="' + Metafans_JS.love_img + '" /> ' + Metafans_JS.love_text
          );
      } else if (reaction_type === "like") {
        _that
          .parents(".th-bp-post-like-button")
          .find("a")
          .attr("data-reaction", "")
          .attr("data-reaction", reaction_type)
          .html(
            '<img src="' + Metafans_JS.like_img + '" /> ' + Metafans_JS.like_text
          );
      }
      jQuery(".reaction_icons").fadeOut(100).delay(1000).fadeIn(100);
      postActivityReaction(reaction_type, activity_id);
    }
  );
  jQuery(document).on("click", ".reactions-meta", function () {
    var _that = jQuery(this);
    var activity_id = _that.attr("data-activity-id");
    jQuery(document).find(".th-activity-reaction-viewer").addClass("show");
    jQuery.ajax({
      url: Metafans_JS.ajaxurl,
      type: "post",
      data: {
        action: "th_bp_activity_all_reaction",
        activity_id: activity_id,
      },
      success: function (response) {
        jQuery(document)
          .find(".th-activity-reaction-viewer .reactions")
          .html(response);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
      },
    });
  });
  jQuery(document).on(
    "click",
    ".th-activity-reaction-viewer .close",
    function () {
      jQuery(".th-activity-reaction-viewer").removeClass("show");
    }
  );
  jQuery(document).on(
    "click",
    ".th-activity-reaction-viewer .reactions ul.reaction_tabs li a",
    function (e) {
      e.preventDefault();
      var tab_id = jQuery(this).attr("href");
      jQuery(
        ".th-activity-reaction-viewer .reactions ul.reaction_tabs li a"
      ).removeClass("active");
      jQuery(this).addClass("active");
      jQuery(
        ".th-activity-reaction-viewer .reactions .reaction_container .single-reactions"
      ).hide();
      jQuery(
        ".th-activity-reaction-viewer .reactions .reaction_container .single-reactions" +
          tab_id
      ).show();
    }
  );
  jQuery(document).on("click", ".th-bp-post-like-button a", function () {
    var _that = jQuery(this);
    var present_class = _that.attr("data-reaction");
    if (present_class !== "") {
      var reaction_type = "decrement";
      _that
        .parents(".th-bp-post-like-button")
        .find("a")
        .attr("data-reaction", "")
        .html(Metafans_JS.like_base_img + Metafans_JS.like_base_text);
    } else {
      var reaction_type = "like";
      _that
        .parents(".th-bp-post-like-button")
        .find("a")
        .attr("data-reaction", reaction_type)
        .html(
          '<img src="' + Metafans_JS.like_img + '" /> ' + Metafans_JS.like_text
        );
    }
    var activity_id = _that.attr("data-id");

    postActivityReaction(reaction_type, activity_id);
  });
  function hideReactions(reaction) {
    jQuery(reaction).parent().hide();
    setTimeout(function () {
      jQuery(reaction).parent().show();
    }, 5);
  }
  function postActivityReaction(reaction_type, activity_id) {
    jQuery.ajax({
      url: Metafans_JS.ajaxurl,
      type: "post",
      data: {
        action: "th_bp_activity_reaction",
        reaction_type: reaction_type,
        activity_id: activity_id,
      },
      success: function (response) {
        // jQuery('.th-bp-media-comment-button').remove();
        // jQuery('.comment_section').prepend(response);
        // if( response == true ){
        //     setComments( media_id, activity_id );
        // }else{
        console.log(response);
        // }
        jQuery("#activity-" + activity_id)
          .find(".reactions-meta")
          .html(response);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
      },
    });
  }
  /*---------------- Comments Section ----------------*/
  function getComments() {}
  function setComments(media_id, activity_id) {
    jQuery.ajax({
      url: Metafans_JS.ajaxurl,
      type: "post",
      data: {
        action: "th_bp_media_comments",
        media_id: media_id,
        activity_id: activity_id,
      },
      beforeSend: function () {
        jQuery(
          ".th-media-viewer-container .th-media-comments .comment_section"
        ).html('<span class="comments_loading"></span>');
      },
      success: function (response) {
        jQuery(
          ".th-media-viewer-container .th-media-comments .comment_section"
        ).html(response);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
      },
    });
  }
  function tophiveActivityComments(
    activity_id,
    comment_text,
    comment_id = "",
    type = "postComment"
  ) {
    if (comment_text !== "") {
      jQuery.ajax({
        url: Metafans_JS.ajaxurl,
        type: "post",
        data: {
          action: "tophive_bp_activity_comment",
          comment_text: comment_text,
          activity_id: activity_id,
          comment_id: comment_id,
          type: type,
        },
        beforeSend: function () {
          jQuery(".activity-" + activity_id).addClass("commenting");
          jQuery(".activity-" + activity_id + " .comments-text").attr(
            "contenteditable",
            false
          );
        },
        success: function (response) {
          console.log(response);
          // jQuery('.th-media-viewer-container .th-media-comments .comment_section').html(response);
          if (response.html) {
            jQuery("#activity-" + activity_id + " .activity-comments").html(
              response.html
            );
            jQuery(".activity-" + activity_id).removeClass("commenting");
            jQuery(".activity-" + activity_id + " .comments-text").attr(
              "contenteditable",
              true
            );
          }
          if (response.count) {
            jQuery(".activity-comments-meta-" + activity_id).html(
              response.count
            );
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          console.log(xhr);
        },
      });
    }
  }
  jQuery(document).on("click", ".th_media_comment_submit", function () {
    var comment_text = jQuery(document)
      .find(".media_comment_box .comment_text textarea")
      .val();
    var media_id = jQuery(this).attr("data-media-id");
    var activity_id = jQuery(this).attr("data-activity-id");
    var type = jQuery(this).attr("data-type");
    jQuery(this).attr("disabled", true);
    postNewComment(comment_text, media_id, activity_id);
  });
  /***
   ** Activity Comments
   * Since v1.0.0
   */
  jQuery(document).on("submit", ".tophive-bp-comment-form", function (e) {
    var text = jQuery(this).find(".comments-text").val();
    var activity_id = jQuery(this).attr("data-activity-id");
    var comment_id = jQuery(this).attr("data-comment-id");
    var type = jQuery(this).attr("data-type");
    var comment_box = jQuery(this).find(".comments-text");
    tophiveActivityComments(activity_id, text, comment_id, type);
    return false;
  });
  jQuery(document).on(
    "keypress",
    ".tophive-bp-comment-form .comments-text",
    function (e) {
      if (e.which === 13 && !e.shiftKey) {
        e.preventDefault();
        var activity_id = jQuery(this).parent().attr("data-activity-id");
        var comment_id = jQuery(this).parent().attr("data-comment-id");
        var type = jQuery(this).parent().attr("data-type");
        var text = jQuery(this).html();
        var media_url = jQuery("#comment-media-url-" + activity_id).val();
        if (media_url) {
          var media_html =
            '<div class="comment-media-section"><img src="' +
            media_url +
            '" /></div>';
          text = text + media_html;
        }
        console.log(activity_id, text);
        tophiveActivityComments(activity_id, text, comment_id, type);
      }
    }
  );
  /* ---------------- Show More Comments Button --------------*/
  jQuery(document).on("click", ".show-more-comments", function (e) {
    e.preventDefault();
    var show = jQuery(this).attr("data-show");
    var activity_id = jQuery(this).attr("data-activity-id");
    jQuery.ajax({
      url: Metafans_JS.ajaxurl,
      type: "post",
      data: {
        action: "tophive_bp_more_comments",
        show: show,
        activity_id: activity_id,
      },
      success: function (response) {
        jQuery("#activity-" + activity_id + " .activity-comments").html(
          response
        );
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
      },
    });
  });
  /*----------------- Show Comment Reply form -----------------*/
  jQuery(document).on("click", ".comment-reply-form-toggle", function (e) {
    e.preventDefault();
    var id = jQuery(this).attr("href");
    jQuery(id).toggleClass("show");
  });
  jQuery(document).on("click", ".th-bp-post-comment-button a", function (e) {
    e.preventDefault();

    const rootItem = e.target.closest(".activity-item");

    const el = rootItem.querySelector(".comments-text");
    const selection = window.getSelection();
    const range = document.createRange();
    selection.removeAllRanges();
    range.selectNodeContents(el);
    range.collapse(false);
    selection.addRange(range);
    el.focus();
  });
  jQuery(document).on("click", ".activity-comments-toggle", function (e) {
    e.preventDefault();
    var id = jQuery(this).attr("href");
    // console.log(id);
    jQuery(id).slideToggle(200);
    jQuery(id + " + .show-more-comments").slideToggle(100);
  });
  function postNewComment(comment_text, media_id, activity_id) {
    jQuery.ajax({
      url: Metafans_JS.ajaxurl,
      type: "post",
      data: {
        action: "th_bp_media_comments_post",
        comment_text: comment_text,
        media_id: media_id,
        activity_id: activity_id,
      },
      success: function (response) {
        if (response == true) {
          setComments(media_id, activity_id);
        } else {
          console.log(response);
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
      },
    });
  }
  function postCommentReaction(reaction_type, media_id, activity_id) {
    jQuery.ajax({
      url: Metafans_JS.ajaxurl,
      type: "post",
      data: {
        action: "th_bp_media_reaction",
        reaction_type: reaction_type,
        media_id: media_id,
        activity_id: activity_id,
      },
      success: function (response) {
        document.querySelector(".th-bp-media-comment-button").remove();
        document
          .querySelector(".comment_section")
          .insertAdjacentHTML("afterbegin", response);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
      },
    });
  }
  // Comments delete
  jQuery(document).on("click", "a.comment-delete", function (e) {
    e.preventDefault();
    var r = confirm(Metafans_JS.delete_comment);
    if (r == true) {
      var comment_id = jQuery(this).attr("data-comment-id");
      var activity_id = jQuery(this).attr("data-activity-id");
      var reply_id = jQuery(this).attr("data-reply-id");
      deleteComment(activity_id, comment_id, reply_id);
    }
  });
  function deleteComment(activity_id, comment_id, reply_id) {
    jQuery.ajax({
      url: Metafans_JS.ajaxurl,
      type: "post",
      data: {
        action: "tophive_bp_delete_comment",
        activity_id: activity_id,
        comment_id: comment_id,
        reply_id: reply_id,
      },
      success: function (response) {
        console.log(response);
        if (response.html) {
          jQuery("#activity-" + activity_id + " .activity-comments").html(
            response.html
          );
        }
        if (response.count) {
          jQuery(".activity-comments-meta-" + activity_id).html(response.count);
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
      },
    });
  }
  // End comment delete
  function editComment() {}
  jQuery(document).keyup(function (e) {
    if (e.key === "Escape") {
      jQuery(".th-media-viewer-container").removeClass("show");
    }
    if (e.keyCode == 37) {
      jQuery(document).find(".image-viewer-next-prev .img-prev").click();
    }
    if (e.keyCode == 39) {
      jQuery(document).find(".image-viewer-next-prev .img-next").click();
    }
  });

  jQuery( document ).on("click", ".notification-actions a", function( e ){
    e.preventDefault();
    var _that = jQuery(this);
    var Action = _that.attr("data-action");
    var notification_id = _that.attr("data-notification-id");
    if( Action === "delete" ){
      jQuery(".metafans-alert-popup.notification-delete").addClass("open");
      jQuery( document ).on("click", ".confirm-delete-notification", function( e ){
        
        e.preventDefault();
        jQuery(".metafans-alert-popup").removeClass("open");
        jQuery.ajax({
          url: Metafans_JS.ajaxurl,
          type: "post",
          data: {
            action: "handle_notification",
            Action: "delete",
            notification_id
          },
          beforeSend: function () {
            console.log("loading");
          },
          success: function (data) {
            // console.log(data);
            showNotification(data.response_type, data.response_msg);
            window.location.reload();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
          },
        });
      });
    }else{
      jQuery.ajax({
        url: Metafans_JS.ajaxurl,
        type: "post",
        data: {
          action: "handle_notification",
          Action,
          notification_id
        },
        beforeSend: function () {
          console.log("loading");
        },
        success: function (data) {
          showNotification(data.response_type, data.response_msg);
          window.location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          console.log(xhr);
        },
      });
    }

  });


  jQuery(document).on("click", ".th-bp-logged-out a", function (e) {
    e.preventDefault();
    jQuery("#tophive-signin-signup").addClass("open");
  });
  jQuery(document).on("click", ".v-menu-toggler", function (e) {
    jQuery(this).parents(".tophive-vertical-nav").toggleClass("open");
    jQuery("body").toggleClass("v-nav-open");
  });
  jQuery(document).on(
    "click",
    ".th-bp-post-share-button a.activity-share",
    function (e) {
      e.preventDefault();
      jQuery(this).parent().find(".sharing-options").toggleClass("open");
    }
  );
  jQuery(document).on("click", "a.timeline-share", function (e) {
    var loading_icon =
      '<svg class="sharing-spinner" viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle></svg>';
    var share_icon =
      '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>';
    var ok_icon =
      '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16"><path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/></svg>';
    e.preventDefault();
    var _that = jQuery(this);
    var activity_id = _that.attr("href");
    jQuery.ajax({
      url: Metafans_JS.ajaxurl,
      type: "post",
      data: {
        action: "tophive_bp_share_activity",
        activity_id: activity_id,
      },
      beforeSend: function () {
        _that.parents(".sharing-options").removeClass("open");
        _that
          .parents(".th-bp-post-share-button")
          .find("a.activity-share .share_icon")
          .html(loading_icon);
      },
      success: function (response) {
        console.log(response);
        if (response) {
          _that
            .parents(".th-bp-post-share-button")
            .find("a.activity-share .share_icon")
            .html(ok_icon);
        }
        setTimeout(function () {
          _that
            .parents(".th-bp-post-share-button")
            .find("a.activity-share .share_icon")
            .html(share_icon);
        }, 2000);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
      },
    });
  });
  jQuery(document).on("click", ".bp-th-friends-button", function (e) {
    e.preventDefault();
    var loading_icon =
      '<svg class="sharing-spinner" viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle></svg>';
    var user_id = jQuery(this).attr("data-user-id");
    var _that = jQuery(this);
    jQuery.ajax({
      url: Metafans_JS.ajaxurl,
      type: "post",
      data: {
        action: "tophive_bp_friends_action",
        user_id: user_id,
      },
      beforeSend: function () {
        _that.html(loading_icon);
      },
      success: function (response) {
        console.log(response);
        if (response.result === true) {
          _that.html(response.text);
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
      },
    });
  });
  jQuery(document).on("click", ".bp-th-follow-button", function (e) {
    e.preventDefault();
    // var loading_icon =
      // '<svg class="sharing-spinner" viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle></svg>';
    var following_id  = jQuery(this).attr("data-following-id");
    var follower_id   = jQuery(this).attr("data-follower-id");
    var status   = jQuery(this).attr("data-following");
    var _that         = jQuery(this);
    jQuery.ajax({
      url   : Metafans_JS.ajaxurl,
      type  : "post",
      data  : {
        action        : "metafans_handle_follow",
        following_id  : following_id,
        follower_id   : follower_id
      },
      beforeSend: function () {
        _that.toggleClass('following');
        console.log( status );
        status === 'following' ? 
          _that.html(Metafans_JS.follow) : _that.html(Metafans_JS.following);
        // console.log('Following...');
      },
      success: function (response) {
        console.log(response);
        if (response.is_following) {
          _that.attr( 'data-following', 'following' );
          jQuery('.followers-count-' + following_id).html(response.followers_count);
          jQuery('.following-count-' + follower_id).html(response.following_count);
        }else{
          _that.attr( 'data-following', '' );
          jQuery('.followers-count-' + following_id).html(response.followers_count);
          jQuery('.following-count-' + follower_id).html(response.following_count);
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr);
      },
    });
  });

  // create group progress script
  function createGroupProgress() {
    const groupProgNavs = document.querySelectorAll(".group-create-buttons li");
    //get how many progress is complete
    let index;
    for (let i = 0; i < groupProgNavs.length; i++) {
      if (groupProgNavs[i].className === "current") {
        index = i;
      }
    }

    const genarateHtml = (isCompleate, number, text, isLast) => {
      return `<span class="nm ${isCompleate ? "cnm" : ""}">${number}</span>
	      <span class="txt ${isCompleate ? "ctxt" : ""}">${text}</span>
	      ${
          !isLast
            ? '<svg  width="12" height="12"  viewBox="0 0 512.002 512.002"><path d="M388.425,241.951L151.609,5.79c-7.759-7.733-20.321-7.72-28.067,0.04c-7.74,7.759-7.72,20.328,0.04,28.067l222.72,222.105    L123.574,478.106c-7.759,7.74-7.779,20.301-0.04,28.061c3.883,3.89,8.97,5.835,14.057,5.835c5.074,0,10.141-1.932,14.017-5.795    l236.817-236.155c3.737-3.718,5.834-8.778,5.834-14.05S392.156,245.676,388.425,241.951z"></path></svg>'
            : ""
        }`;
    };

    //add arrow and design to completed progress
    if (index >= 0) {
      for (let i = 0; i < groupProgNavs.length; i++) {
        const el = groupProgNavs[i];

        if (i <= index) {
          const atag = el.querySelector("a");
          const text = atag.innerText.split(".");
          //add new html to element
          atag.innerHTML = genarateHtml(
            true,
            text[0],
            text[1],
            i === groupProgNavs.length - 1
          );
        } else {
          let stag = el.querySelector("span");
          if (!stag) stag = el.querySelector("a"); //span tag is messing when back to previous step
          const text = stag.innerText.split(".");
          //add new html to element
          stag.innerHTML = genarateHtml(
            false,
            text[0],
            text[1],
            i === groupProgNavs.length - 1
          );
        }
        //
      }
    }
  }
  createGroupProgress(); //end create group progress script

  //start edite visibility script
  const visibilityData = [
    {
      id: 1,
      vi: "public",
      content: `<span class="ac-vi-co" data-vi="1"><span class="ac_vi_text"> Public </span><svg viewBox="0 0 512 512" width="16" height="16" fill="#555"><path d="M414.39 97.74A224 224 0 1097.61 414.52 224 224 0 10414.39 97.74zM64 256.13a191.63 191.63 0 016.7-50.31c7.34 15.8 18 29.45 25.25 45.66 9.37 20.84 34.53 15.06 45.64 33.32 9.86 16.21-.67 36.71 6.71 53.67 5.36 12.31 18 15 26.72 24 8.91 9.08 8.72 21.52 10.08 33.36a305.36 305.36 0 007.45 41.27c0 .1 0 .21.08.31C117.8 411.13 64 339.8 64 256.13zm192 192a193.12 193.12 0 01-32-2.68c.11-2.71.16-5.24.43-7 2.43-15.9 10.39-31.45 21.13-43.35 10.61-11.74 25.15-19.68 34.11-33 8.78-13 11.41-30.5 7.79-45.69-5.33-22.44-35.82-29.93-52.26-42.1-9.45-7-17.86-17.82-30.27-18.7-5.72-.4-10.51.83-16.18-.63-5.2-1.35-9.28-4.15-14.82-3.42-10.35 1.36-16.88 12.42-28 10.92-10.55-1.41-21.42-13.76-23.82-23.81-3.08-12.92 7.14-17.11 18.09-18.26 4.57-.48 9.7-1 14.09.68 5.78 2.14 8.51 7.8 13.7 10.66 9.73 5.34 11.7-3.19 10.21-11.83-2.23-12.94-4.83-18.21 6.71-27.12 8-6.14 14.84-10.58 13.56-21.61-.76-6.48-4.31-9.41-1-15.86 2.51-4.91 9.4-9.34 13.89-12.27 11.59-7.56 49.65-7 34.1-28.16-4.57-6.21-13-17.31-21-18.83-10-1.89-14.44 9.27-21.41 14.19-7.2 5.09-21.22 10.87-28.43 3-9.7-10.59 6.43-14.06 10-21.46 1.65-3.45 0-8.24-2.78-12.75q5.41-2.28 11-4.23a15.6 15.6 0 008 3c6.69.44 13-3.18 18.84 1.38 6.48 5 11.15 11.32 19.75 12.88 8.32 1.51 17.13-3.34 19.19-11.86 1.25-5.18 0-10.65-1.2-16a190.83 190.83 0 01105 32.21c-2-.76-4.39-.67-7.34.7-6.07 2.82-14.67 10-15.38 17.12-.81 8.08 11.11 9.22 16.77 9.22 8.5 0 17.11-3.8 14.37-13.62-1.19-4.26-2.81-8.69-5.42-11.37a193.27 193.27 0 0118 14.14c-.09.09-.18.17-.27.27-5.76 6-12.45 10.75-16.39 18.05-2.78 5.14-5.91 7.58-11.54 8.91-3.1.73-6.64 1-9.24 3.08-7.24 5.7-3.12 19.4 3.74 23.51 8.67 5.19 21.53 2.75 28.07-4.66 5.11-5.8 8.12-15.87 17.31-15.86a15.4 15.4 0 0110.82 4.41c3.8 3.94 3.05 7.62 3.86 12.54 1.43 8.74 9.14 4 13.83-.41a192.12 192.12 0 019.24 18.77c-5.16 7.43-9.26 15.53-21.67 6.87-7.43-5.19-12-12.72-21.33-15.06-8.15-2-16.5.08-24.55 1.47-9.15 1.59-20 2.29-26.94 9.22-6.71 6.68-10.26 15.62-17.4 22.33-13.81 13-19.64 27.19-10.7 45.57 8.6 17.67 26.59 27.26 46 26 19.07-1.27 38.88-12.33 38.33 15.38-.2 9.81 1.85 16.6 4.86 25.71 2.79 8.4 2.6 16.54 3.24 25.21a158 158 0 004.74 30.07A191.75 191.75 0 01256 448.13z"/></svg></span>`,
    },
    {
      id: 2,
      vi: "friends",
      content: `<span class="ac-vi-co" data-vi="2"><span class="ac_vi_text"> Friends </span><svg viewBox="0 0 512 512" fill="#555"><path d="M336 256c-20.56 0-40.44-9.18-56-25.84-15.13-16.25-24.37-37.92-26-61-1.74-24.62 5.77-47.26 21.14-63.76S312 80 336 80c23.83 0 45.38 9.06 60.7 25.52 15.47 16.62 23 39.22 21.26 63.63-1.67 23.11-10.9 44.77-26 61C376.44 246.82 356.57 256 336 256zm66-88zM467.83 432H204.18a27.71 27.71 0 01-22-10.67 30.22 30.22 0 01-5.26-25.79c8.42-33.81 29.28-61.85 60.32-81.08C264.79 297.4 299.86 288 336 288c36.85 0 71 9 98.71 26.05 31.11 19.13 52 47.33 60.38 81.55a30.27 30.27 0 01-5.32 25.78A27.68 27.68 0 01467.83 432zM147 260c-35.19 0-66.13-32.72-69-72.93-1.42-20.6 5-39.65 18-53.62 12.86-13.83 31-21.45 51-21.45s38 7.66 50.93 21.57c13.1 14.08 19.5 33.09 18 53.52-2.87 40.2-33.8 72.91-68.93 72.91zM212.66 291.45c-17.59-8.6-40.42-12.9-65.65-12.9-29.46 0-58.07 7.68-80.57 21.62-25.51 15.83-42.67 38.88-49.6 66.71a27.39 27.39 0 004.79 23.36A25.32 25.32 0 0041.72 400h111a8 8 0 007.87-6.57c.11-.63.25-1.26.41-1.88 8.48-34.06 28.35-62.84 57.71-83.82a8 8 0 00-.63-13.39c-1.57-.92-3.37-1.89-5.42-2.89z"/></svg></span>`,
    },
    {
      id: 3,
      vi: "onlyme",
      content: `<span class="ac-vi-co" data-vi="3"><span class="ac_vi_text">Only me </span><svg viewBox="0 0 30 30" width="30px" height="30px"><g id="surface67244366"><path style=" stroke:none;fill-rule:nonzero;fill:#555;fill-opacity:1;" d="M 15 2 C 11.144531 2 8 5.144531 8 9 L 8 11 L 6 11 C 4.894531 11 4 11.894531 4 13 L 4 25 C 4 26.105469 4.894531 27 6 27 L 24 27 C 25.105469 27 26 26.105469 26 25 L 26 13 C 26 11.894531 25.105469 11 24 11 L 22 11 L 22 9 C 22 5.273438 19.035156 2.269531 15.355469 2.074219 C 15.242188 2.027344 15.121094 2.003906 15 2 Z M 15 4 C 17.773438 4 20 6.226562 20 9 L 20 11 L 10 11 L 10 9 C 10 6.226562 12.226562 4 15 4 Z M 15 4 "/></g></svg></span>`,
    },
  ];

  function editeVisibilityMarkup() {
    const markup = `
	 <div class="ac-vi-pop">
	    <div class="ac-vi-pop-main">
	       <div class="ac-vi-content">
	         <div class="ac-vi-head">
		   <p class="ac-vi-header-text">Who can see your post?</p>
		   <span class="close-ac-vi-popup">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
					<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
				</svg>
		   </span>
		 </div>
		 <div class="ac-vi-options">
		   <div class="ac-vi-option-public">
			<span class="ac-vi-option-svg-bg"><svg id="p-icon" class="ionicon" viewBox="0 0 512 512"><path d="M414.39 97.74A224 224 0 1097.61 414.52 224 224 0 10414.39 97.74zM64 256.13a191.63 191.63 0 016.7-50.31c7.34 15.8 18 29.45 25.25 45.66 9.37 20.84 34.53 15.06 45.64 33.32 9.86 16.21-.67 36.71 6.71 53.67 5.36 12.31 18 15 26.72 24 8.91 9.08 8.72 21.52 10.08 33.36a305.36 305.36 0 007.45 41.27c0 .1 0 .21.08.31C117.8 411.13 64 339.8 64 256.13zm192 192a193.12 193.12 0 01-32-2.68c.11-2.71.16-5.24.43-7 2.43-15.9 10.39-31.45 21.13-43.35 10.61-11.74 25.15-19.68 34.11-33 8.78-13 11.41-30.5 7.79-45.69-5.33-22.44-35.82-29.93-52.26-42.1-9.45-7-17.86-17.82-30.27-18.7-5.72-.4-10.51.83-16.18-.63-5.2-1.35-9.28-4.15-14.82-3.42-10.35 1.36-16.88 12.42-28 10.92-10.55-1.41-21.42-13.76-23.82-23.81-3.08-12.92 7.14-17.11 18.09-18.26 4.57-.48 9.7-1 14.09.68 5.78 2.14 8.51 7.8 13.7 10.66 9.73 5.34 11.7-3.19 10.21-11.83-2.23-12.94-4.83-18.21 6.71-27.12 8-6.14 14.84-10.58 13.56-21.61-.76-6.48-4.31-9.41-1-15.86 2.51-4.91 9.4-9.34 13.89-12.27 11.59-7.56 49.65-7 34.1-28.16-4.57-6.21-13-17.31-21-18.83-10-1.89-14.44 9.27-21.41 14.19-7.2 5.09-21.22 10.87-28.43 3-9.7-10.59 6.43-14.06 10-21.46 1.65-3.45 0-8.24-2.78-12.75q5.41-2.28 11-4.23a15.6 15.6 0 008 3c6.69.44 13-3.18 18.84 1.38 6.48 5 11.15 11.32 19.75 12.88 8.32 1.51 17.13-3.34 19.19-11.86 1.25-5.18 0-10.65-1.2-16a190.83 190.83 0 01105 32.21c-2-.76-4.39-.67-7.34.7-6.07 2.82-14.67 10-15.38 17.12-.81 8.08 11.11 9.22 16.77 9.22 8.5 0 17.11-3.8 14.37-13.62-1.19-4.26-2.81-8.69-5.42-11.37a193.27 193.27 0 0118 14.14c-.09.09-.18.17-.27.27-5.76 6-12.45 10.75-16.39 18.05-2.78 5.14-5.91 7.58-11.54 8.91-3.1.73-6.64 1-9.24 3.08-7.24 5.7-3.12 19.4 3.74 23.51 8.67 5.19 21.53 2.75 28.07-4.66 5.11-5.8 8.12-15.87 17.31-15.86a15.4 15.4 0 0110.82 4.41c3.8 3.94 3.05 7.62 3.86 12.54 1.43 8.74 9.14 4 13.83-.41a192.12 192.12 0 019.24 18.77c-5.16 7.43-9.26 15.53-21.67 6.87-7.43-5.19-12-12.72-21.33-15.06-8.15-2-16.5.08-24.55 1.47-9.15 1.59-20 2.29-26.94 9.22-6.71 6.68-10.26 15.62-17.4 22.33-13.81 13-19.64 27.19-10.7 45.57 8.6 17.67 26.59 27.26 46 26 19.07-1.27 38.88-12.33 38.33 15.38-.2 9.81 1.85 16.6 4.86 25.71 2.79 8.4 2.6 16.54 3.24 25.21a158 158 0 004.74 30.07A191.75 191.75 0 01256 448.13z"/></svg></span>
			<div>
			   <p class="ac-vi-option-title">Public</p>
			   <span class="ac-vi-option-des">Visible to anyone, on or off this site</span>
			</div>
			<span class="ac-vi-option-selected-fill"></span>
		   </div>
		   <div class="ac-vi-option-friends">
			<span class="ac-vi-option-svg-bg"><svg id="f-icon"  class="ionicon" viewBox="0 0 512 512"><path d="M336 256c-20.56 0-40.44-9.18-56-25.84-15.13-16.25-24.37-37.92-26-61-1.74-24.62 5.77-47.26 21.14-63.76S312 80 336 80c23.83 0 45.38 9.06 60.7 25.52 15.47 16.62 23 39.22 21.26 63.63-1.67 23.11-10.9 44.77-26 61C376.44 246.82 356.57 256 336 256zm66-88zM467.83 432H204.18a27.71 27.71 0 01-22-10.67 30.22 30.22 0 01-5.26-25.79c8.42-33.81 29.28-61.85 60.32-81.08C264.79 297.4 299.86 288 336 288c36.85 0 71 9 98.71 26.05 31.11 19.13 52 47.33 60.38 81.55a30.27 30.27 0 01-5.32 25.78A27.68 27.68 0 01467.83 432zM147 260c-35.19 0-66.13-32.72-69-72.93-1.42-20.6 5-39.65 18-53.62 12.86-13.83 31-21.45 51-21.45s38 7.66 50.93 21.57c13.1 14.08 19.5 33.09 18 53.52-2.87 40.2-33.8 72.91-68.93 72.91zM212.66 291.45c-17.59-8.6-40.42-12.9-65.65-12.9-29.46 0-58.07 7.68-80.57 21.62-25.51 15.83-42.67 38.88-49.6 66.71a27.39 27.39 0 004.79 23.36A25.32 25.32 0 0041.72 400h111a8 8 0 007.87-6.57c.11-.63.25-1.26.41-1.88 8.48-34.06 28.35-62.84 57.71-83.82a8 8 0 00-.63-13.39c-1.57-.92-3.37-1.89-5.42-2.89z"/></svg></span>
			<div>
			   <p class="ac-vi-option-title">Friends</p>
			   <span class="ac-vi-option-des">Visible only to your connections</span>
			</div>
			<span class="ac-vi-option-selected-fill"></span>
		   </div>
		   <div class="ac-vi-option-onlyme">
			<span class="ac-vi-option-svg-bg"><svg viewBox="0 0 30 30"><g id="surface67244366"><path style=" stroke:none;fill-rule:nonzero;fill-opacity:1;" d="M 15 2 C 11.144531 2 8 5.144531 8 9 L 8 11 L 6 11 C 4.894531 11 4 11.894531 4 13 L 4 25 C 4 26.105469 4.894531 27 6 27 L 24 27 C 25.105469 27 26 26.105469 26 25 L 26 13 C 26 11.894531 25.105469 11 24 11 L 22 11 L 22 9 C 22 5.273438 19.035156 2.269531 15.355469 2.074219 C 15.242188 2.027344 15.121094 2.003906 15 2 Z M 15 4 C 17.773438 4 20 6.226562 20 9 L 20 11 L 10 11 L 10 9 C 10 6.226562 12.226562 4 15 4 Z M 15 4 "/></g></svg></span>
			<div>
			  <p class="ac-vi-option-title">Only me</p>
			   <span class="ac-vi-option-des">Visible only to you</span>
			</div>
			<span class="ac-vi-option-selected-fill"></span>
		   </div>
		 </div>
	       </div>
	    </div>
	 </div>`;
    return markup;
  }

  function updateVisibility(acId, visiType) {
    console.log(acId);
    jQuery.ajax({
      url: Metafans_JS.ajaxurl,
      type: "post",
      data: {
        action: "th_bp_update_activity_visibility",
        activity_id: acId,
        activity_accessibility: visiType,
      },
      success: function (response) {
        console.log(response);
      },
    });
  }

  function changeVisibilityIcon(eventTarget, iconIn) {
    const parentDom = eventTarget.parentElement;
    eventTarget.remove();
    parentDom.insertAdjacentHTML("beforeend", visibilityData[iconIn].content);
  }

  function selectVisibilityHandeler(eventTarget, acId) {
    const acPop = document.querySelector(".ac-vi-pop");
    const options = acPop.querySelector(".ac-vi-options").children;

    Array.from(options).forEach((cur, i) => {
      cur.addEventListener("click", (e) => {
        activeVisibility(i);
        changeVisibilityIcon(eventTarget, i);

        updateVisibility(parseInt(acId), visibilityData[i].vi);

        closeEditeVisibilityPopup();
      });
    });

    const acClosePopIcon = acPop.querySelector(".close-ac-vi-popup");
    if (acClosePopIcon) {
      acClosePopIcon.addEventListener("click", (e) => {
        closeEditeVisibilityPopup();
      });
    }
  }

  function closeEditeVisibilityPopup() {
    const acPop = document.querySelector(".ac-vi-pop");
    if (!acPop) return;
    acPop.remove();
  }

  function activeVisibility(elIn) {
    const options = document.querySelector(".ac-vi-options").children;
    if (!options.length) return;
    Array.from(options).forEach((cur) => cur.classList.remove("ac-vi-active"));
    options[elIn].classList.add("ac-vi-active");
  }

  function openEditeVisibilityPopup(eventTarget, acId) {
    //close previous popup
    closeEditeVisibilityPopup();
    //open new popup
    document
      .querySelector("body")
      .insertAdjacentHTML("afterbegin", editeVisibilityMarkup());
    //add handler
    selectVisibilityHandeler(eventTarget, acId);
  }

  function initEditeVisibility() {
    const activityCon = document.getElementById("activity-stream");
    if (!activityCon) return;

    //add listener
    activityCon.addEventListener("click", (e) => {
      const visibilityIcon = e.target.closest(".ac-vi-co");
      if (!visibilityIcon) return;
      e.preventDefault();

      //check if have edite permision or not
      const acItemDom = visibilityIcon.closest(".activity-item");
      const hasPermision = acItemDom.dataset.canedite;
      if (!hasPermision || hasPermision === "false") return;

      const acId = acItemDom.dataset.bpActivityId;
      if (!acId) return;

      openEditeVisibilityPopup(visibilityIcon, parseInt(acId));

      const acviId = visibilityIcon.dataset.vi;
      if (!acviId) return;

      activeVisibility(parseInt(acviId) - 1);
    });
  }
  initEditeVisibility(); //end edite visibility script

  //start activity  action button script
  const favoriteMarkup = {
    unsave: `
    <li>
	<a class="button bp-secondary-action bp-tooltip activity-remove-favourite" href="">
	   <svg viewBox="0 0 212.045 212.045" style="fill: #484646;">
		<path d="M167.871,0H44.84C34.82,0,26.022,8.243,26.022,18v182c0,3.266,0.909,5.988,2.374,8.091c1.752,2.514,4.573,3.955,7.598,3.954  c2.86,0,5.905-1.273,8.717-3.675l55.044-46.735c1.7-1.452,4.142-2.284,6.681-2.284c2.538,0,4.975,0.832,6.68,2.288l54.86,46.724  c2.822,2.409,5.657,3.683,8.512,3.683c4.828,0,9.534-3.724,9.534-12.045V18C186.022,8.243,177.891,0,167.871,0z"></path>
	   </svg>
	   <div>
		<h4>Unsave</h4>
		<p>Unsave this activity</p>
	   </div>
	</a>
    </li>`,
    save: `
	<li>
	    <a class="button bp-secondary-action bp-tooltip activity-make-favourite" href="">
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
		<div>
		    <h4>Save</h4>
		    <p>Save this post / add to favourite</p>
		</div>
	    </a>
	</li>`,
  };

  function activityOptionOpenHandleer(icon) {
    document
      .querySelectorAll(".activity-extension-links")
      .forEach((cur) => cur.classList.remove("ac-action-open"));
    const ulEl = icon.parentElement;
    ulEl.classList.add("ac-action-open");
  }

  function activityDeleteActionHandler(deletIcon, e) {
    var activity_id = deletIcon.getAttribute("data-id");
    var action = deletIcon.getAttribute("data-action");
    jQuery(".confirm-delete-activity").attr({
      "data-id": activity_id,
      "data-action": action,
    });
    jQuery(".metafans-alert-popup.activity-delete").addClass("open");
  }

  async function activityFavoriteActionHandler(favoriteIcon, e, mode) {
    const { bpActivityId } = e.target.closest(".activity-item").dataset;
    if (!bpActivityId) throw new Error("No activity id found");

    //favoriteIcon.classList.add("loading");

    try {
      const res = await jQuery.ajax({
        type: "post",
        url: mf_local.ajaxurl,
        data: {
          activity_id: bpActivityId,
          action: "th_bp_add_favourite_activity",
          action_type: mode, //either add or delete
        },
      });

      showNotification("success", res);
      const ulEl = favoriteIcon.parentElement.parentElement;
      //remove favourite element
      favoriteIcon.parentElement.remove();
      if (mode === "add") {
        //add new unsave markup
        ulEl.insertAdjacentHTML("afterbegin", favoriteMarkup.unsave);
      }
      if (mode === "delete") {
        //add new save markup
        ulEl.insertAdjacentHTML("afterbegin", favoriteMarkup.save);
      }
      document.querySelector("body").click();
    } catch (err) {
      console.log(err);
      showNotification("error", err);
    }
  }

  async function getFullActivityContent(e, readMoreBtnEl) {
    const { bpActivityId } = e.target.closest(".activity-item").dataset;
    if (!bpActivityId) throw new Error("No activity id found");

    try {
      const res = await jQuery.ajax({
        type: "post",
        url: mf_local.ajaxurl,
        data: {
          activity_id: bpActivityId,
          action: "mf_get_activity_content_by_id",
        },
      });
      console.log(res);
      const con = readMoreBtnEl.parentElement.parentElement;
      // con.innerHTML = res.replace(/\\/g, "");
    } catch (err) {
      console.log(err);
    }
  }

  function initActivityActionButtonClick() {
    const streamConEl = document.querySelector("#activity-stream");
    if (!streamConEl) return;
    streamConEl.addEventListener("click", (e) => {
      const icon = e.target.closest(".open-button");
      if (icon) {
        activityOptionOpenHandleer(icon);
      }

      const deletIcon = e.target.closest(".button-activity-delete");
      if (deletIcon) {
        e.preventDefault();
        activityDeleteActionHandler(deletIcon, e);
      }

      const favoriteIcon = e.target.closest(".activity-make-favourite");
      if (favoriteIcon) {
        e.preventDefault();
        activityFavoriteActionHandler(favoriteIcon, e, "add");
      }
      const unSaveIcon = e.target.closest(".activity-remove-favourite");
      if (unSaveIcon) {
        e.preventDefault();
        activityFavoriteActionHandler(unSaveIcon, e, "delete");
      }

      const readMoreBtn = e.target.closest(".activity-read-more");
      if (readMoreBtn) {
        e.preventDefault();
        e.stopPropagation();
        // getFullActivityContent(e, readMoreBtn);
      }
    });

    window.addEventListener("click", (e) => {
      const actionEl = e.target.closest(".activity-extension-links");
      if (actionEl) {
      } else {
        document
          .querySelectorAll(".activity-extension-links")
          .forEach((cur) => cur.classList.remove("ac-action-open"));
      }
    });
  }
  initActivityActionButtonClick();
});
