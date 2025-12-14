document.addEventListener("DOMContentLoaded", function() {
    // 現在のページのURLをキーにしてスクロール位置を管理（これで他ページと混ざらない）
    const storageKey = 'scrollPos_' + window.location.pathname;

    // 1. 画面が開かれた時、このページ用の保存された位置があれば復元
    const scrollPos = localStorage.getItem(storageKey);
    if (scrollPos) {
        window.scrollTo(0, parseInt(scrollPos));
        localStorage.removeItem(storageKey);
    }

    // 2. 「.js-auto-submit」というクラスがついた要素が変更されたら送信
    const triggers = document.querySelectorAll('.js-auto-submit');

    triggers.forEach(function(trigger) {
        trigger.addEventListener('change', function() {
            // 現在のスクロール位置を保存
            localStorage.setItem(storageKey, window.scrollY);
            
            // 変更された要素が所属しているフォームを自動送信
            this.form.submit();
        });
    });
});