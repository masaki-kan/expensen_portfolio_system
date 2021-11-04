

///ローディング
const loader = document.getElementById('js-loader');
window.addEventListener('load', () => {
  const ms = 400;
  loader.style.transition = 'opacity ' + ms + 'ms';

  const loaderOpacity = function () {
    loader.style.opacity = 0;
  }
  const loaderDisplay = function () {
    loader.style.display = "none";
  }
  setTimeout(loaderOpacity, 1000);
  setTimeout(loaderDisplay, 1000 + ms);

});


/****form imageプレビュー */
document.getElementById('image').addEventListener('change', function (e) {
  // 1枚だけ表示する
  var file = e.target.files[0];

  // ファイルのブラウザ上でのURLを取得する
  var blobUrl = window.URL.createObjectURL(file);

  // img要素に表示
  var img = document.getElementById('preview');
  img.src = blobUrl;
});







