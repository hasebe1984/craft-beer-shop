const imageElement = document.getElementById('loop-image'); // 画像要素のID
const totalImages = 8; // 画像の総数（01.jpg から 08.jpg まで）
const intervalTime = 2000; // 切り替え間隔（ミリ秒。例: 2000ms = 2秒）

let currentIndex = 1; // 現在の画像番号 (01から始まるので初期値は1)

function changeImage() {
    // 1. 次の画像番号を計算
    currentIndex++;

    // 2. 8番目の次の画像番号をチェックし、1に戻す (ループ処理)
    if (currentIndex > totalImages) {
        currentIndex = 1;
    }

    // 3. 画像番号を '01', '02' の形式に変換（ゼロパディング）
    // 例: 1 => '01', 8 => '08'
    const imageNumber = currentIndex.toString().padStart(2, '0');

    // 4. 画像の src属性を更新
    // 例: images/03.jpg に更新される
    imageElement.src = `img/top/${imageNumber}.jpg`;
}

// ページ読み込み後にタイマーを開始
window.addEventListener('load', () => {
    // 処理開始前に、画像要素がHTMLに存在するか確認
    if (imageElement) {
        // setInterval関数で、指定した間隔ごとに changeImage 関数を呼び出す
        setInterval(changeImage, intervalTime);
    }
});
