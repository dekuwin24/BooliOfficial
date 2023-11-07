console.log("search page script loaded");
console.log(searchUrl);

const searchtext = new URLSearchParams(location.search).get("s");
console.log(searchtext);

async function getSearchResult(post_type, posts_per_page, searchtext, offset) {
  try {
    const res = await jQuery.ajax({
      type: "post",
      url: searchUrl, // this searchUrl exist in search page
      data: {
        post_type,
        posts_per_page,
        searchtext,
        offset,
      },
    });
    return res;
  } catch (err) {
    console.log(err);
  }
}

function tabClickHandler(data) {
  console.log(data);
}

const tabsConEl = document.querySelector(".search-page-tabs");

tabsConEl.addEventListener("click", async (e) => {
  if (e.target.matches("#mf-search-user-tab")) {
    const res = await getSearchResult("USERS", 10, searchtext, 0);
  }
  if (e.target.matches("#mf-search-activity-tab")) {
    const res = await getSearchResult("ACTIVITY", 10, searchtext, 0);
  }
});
