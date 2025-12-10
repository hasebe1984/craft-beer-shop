const totalPages = 10;
let currentPage = 1;

function renderPagination(currentPage, totalPages) {
    const container = document.querySelector('.c-pagination');
    container.innerHTML = ''; // 初期化

    // 左矢印
    const prev = document.createElement('a');
    prev.textContent = '<';
    prev.className = 'prev';
    prev.href = '#';
    prev.onclick = () => {
        if (currentPage > 1) renderPagination(currentPage - 1, totalPages);
    };
    container.appendChild(prev);

    // ページ番号（1～5表示＋...＋最後）
    for (let i = 1; i <= totalPages; i++) {
        if (i == 1 || i == totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
            const pageLink = document.createElement('a');
            pageLink.textContent = i;
            pageLink.href = '#';
            if (i == currentPage) pageLink.className = 'active';
            pageLink.onclick = () => renderPagination(i, totalPages);
            container.appendChild(pageLink);
        } else if (i == currentPage - 3 || i == currentPage + 3) {
            const dots = document.createElement('span');
            dots.textContent = '...';
            container.appendChild(dots);
        }
    }

    // 右矢印
    const next = document.createElement('a');
    next.textContent = '>';
    next.className = 'next';
    next.href = '#';
    next.onclick = () => {
        if (currentPage < totalPages) renderPagination(currentPage + 1, totalPages);
    };
    container.appendChild(next);
}

// 初期表示
renderPagination(1, 10);
