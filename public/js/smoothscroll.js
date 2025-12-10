// // DOM要素を取得
// const container = document.querySelector('.scrolling-container');
// const wrapper = document.querySelector('.scrolling-wrapper');

// // 1セット分の幅（アニメーションの移動距離）を計算
// // 最初のセット（前半のコピーされていない部分）の合計幅を取得
// let scrollWidth = 0;
// // 最初の半分（元のセット）のアイテムだけを対象
// const originalItems = Array.from(container.children).slice(0, container.children.length / 2);

// originalItems.forEach((item) => {
//     // 各アイテムの幅とマージンを計算に含める
//     const itemWidth = item.offsetWidth;
//     const itemStyle = window.getComputedStyle(item);
//     const itemMarginRight = parseFloat(itemStyle.marginRight) || 0;
//     scrollWidth += itemWidth + itemMarginRight;
// });

// let currentPosition = 0;
// const scrollSpeed = 0.5; // スクロール速度（ピクセル/フレーム）

// function smoothScroll() {
//     // 1. 左へ移動
//     currentPosition -= scrollSpeed;

//     // 2. 移動位置をコンテナに適用
//     container.style.transform = `translateX(${currentPosition}px)`;

//     // 3. ループ処理（つなぎ目の処理）
//     // currentPosition が 1セット分の幅を超えたら (絶対値で比較)
//     if (Math.abs(currentPosition) >= scrollWidth) {
//         // 瞬間移動させる距離（2セット目の開始位置と1セット目の開始位置の差）
//         // 既に1セット分移動したので、残りの移動距離分だけ戻す

//         // 既に移動した分 (currentPosition) から 1セット分の幅 (scrollWidth) を引いた差分
//         currentPosition += scrollWidth;

//         // トランジションを一時的に無効にし、ジャンプを見えなくする
//         container.style.transition = 'none';
//         container.style.transform = `translateX(${currentPosition}px)`;

//         // トランジションを元に戻す
//         // ブラウザが上記の変更を反映するのを待つためのトリック
//         setTimeout(() => {
//             container.style.transition = 'transform 0.1s linear';
//         }, 50);
//     }

//     requestAnimationFrame(smoothScroll);
// }

// // ページロード後にスクロールを開始
// window.addEventListener('load', () => {
//     // ブラウザのレンダリングを待ってから開始
//     requestAnimationFrame(smoothScroll);
// });

// main.js の内容
// 設定
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

// -----------------------------------------------
let ticking = false;

function updateScrollEffects() {
    const scrollTop = window.pageYOffset;
    const windowHeight = window.innerHeight;

    // 回転要素
    const rotatingElement = document.querySelector('.rotating-element');
    const rotation = (scrollTop / 10) % 360;
    rotatingElement.style.transform = `rotate(${rotation}deg)`;

    // ヒーローセクションのスケール効果
    const heroSection = document.querySelector('.hero-section');
    const heroImage = document.querySelector('.hero-image');
    const heroText = document.querySelector('.hero-text');

    if (heroSection) {
        const heroRect = heroSection.getBoundingClientRect();
        if (heroRect.bottom > 0 && heroRect.top < windowHeight) {
            const progress = Math.abs(heroRect.top) / windowHeight;
            const scale = 1 + progress * 2;
            heroImage.style.transform = `scale(${scale})`;
            heroText.style.opacity = Math.max(0, 1 - progress * 2);
        }
    }

    // 横移動テキスト
    const slidingSection = document.querySelector('.sliding-text-section');
    const slidingText = document.querySelector('.sliding-text');

    if (slidingSection) {
        const rect = slidingSection.getBoundingClientRect();
        if (rect.bottom > 0 && rect.top < windowHeight) {
            const progress = -rect.top / windowHeight;
            const translateX = progress * 50 - 25;
            slidingText.style.transform = `translateX(${translateX}vw)`;
        }
    }

    // 横スクロール効果
    const horizontalWrapper = document.querySelector('.horizontal-scroll-wrapper');
    const horizontalContent = document.querySelector('.horizontal-content');

    if (horizontalWrapper) {
        const rect = horizontalWrapper.getBoundingClientRect();
        const wrapperHeight = horizontalWrapper.offsetHeight;

        if (rect.bottom > 0 && rect.top < windowHeight) {
            const progress = Math.min(1, Math.max(0, -rect.top / (wrapperHeight - windowHeight)));
            const translateX = -progress * 400; // 400vw移動
            horizontalContent.style.transform = `translateX(${translateX}vw)`;
        }
    }

    // パララックス効果
    const parallaxSection = document.querySelector('.parallax-section');
    const parallaxBg = document.querySelector('.parallax-bg');
    const parallaxContent = document.querySelector('.parallax-content');

    if (parallaxSection) {
        const rect = parallaxSection.getBoundingClientRect();
        if (rect.bottom > 0 && rect.top < windowHeight) {
            const progress = -rect.top / windowHeight;
            parallaxBg.style.transform = `translateY(${progress * 100}px)`;

            if (rect.top < windowHeight * 0.5) {
                parallaxContent.classList.add('visible');
            }
        }
    }

    // ズーム効果
    const zoomWrapper = document.querySelector('.zoom-wrapper');
    const zoomImage = document.querySelector('.zoom-image');

    if (zoomWrapper) {
        const rect = zoomWrapper.getBoundingClientRect();
        const wrapperHeight = zoomWrapper.offsetHeight;

        if (rect.bottom > 0 && rect.top < windowHeight) {
            const progress = Math.min(1, Math.max(0, -rect.top / (wrapperHeight - windowHeight)));
            const scale = 1 + progress * 2;
            zoomImage.style.transform = `scale(${scale})`;
        }
    }

    // フェードイン効果
    const fadeInSection = document.querySelector('.fade-in-section');
    const fadeInContent = document.querySelector('.fade-in-content');

    if (fadeInSection) {
        const rect = fadeInSection.getBoundingClientRect();
        if (rect.top < windowHeight * 0.8) {
            fadeInContent.classList.add('visible');
        }
    }

    ticking = false;
}

function requestTick() {
    if (!ticking) {
        requestAnimationFrame(updateScrollEffects);
        ticking = true;
    }
}

// スクロールイベントリスナー
window.addEventListener('scroll', requestTick);

// 初回実行
updateScrollEffects();

// デバッグ用（削除可能）
window.addEventListener('scroll', () => {
    console.log('Scroll position:', window.pageYOffset);
});
