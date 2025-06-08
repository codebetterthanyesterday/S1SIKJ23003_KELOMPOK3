import $ from "jquery";
$(document).ready(function () {
    function renderPagination(pagination, searchValue, entity, tableSelector) {
        let html = "";
        if (pagination.last_page > 1) {
            html +=
                '<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">';
            html += '<div class="flex justify-between flex-1 sm:hidden">';
            // Previous button (mobile)
            if (pagination.current_page === 1) {
                html +=
                    '<span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">Previous</span>';
            } else {
                html += `<a href="#" data-page="${
                    pagination.current_page - 1
                }" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">Previous</a>`;
            }
            // Next button (mobile)
            if (pagination.current_page === pagination.last_page) {
                html +=
                    '<span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">Next</span>';
            } else {
                html += `<a href="#" data-page="${
                    pagination.current_page + 1
                }" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">Next</a>`;
            }
            html += "</div>";

            html +=
                '<div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">';
            // Info text
            html += `<div><p class="text-sm text-gray-700 leading-5">Showing <span class="font-medium">${pagination.from}</span> to <span class="font-medium">${pagination.to}</span> of <span class="font-medium">${pagination.total}</span> results</p></div>`;
            html += "<div>";
            html +=
                '<span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">';
            // Previous button (desktop)
            if (pagination.current_page === 1) {
                html += '<span aria-disabled="true" aria-label="Previous">';
                html +=
                    '<span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5" aria-hidden="true">';
                html +=
                    '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>';
                html += "</span></span>";
            } else {
                html += `<a href="#" data-page="${
                    pagination.current_page - 1
                }" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Previous">`;
                html +=
                    '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>';
                html += "</a>";
            }
            // Page numbers with ellipsis
            let window = 2;
            let first = 1;
            let last = pagination.last_page;
            let current = pagination.current_page;
            let pages = [];
            if (last <= 7) {
                for (let i = 1; i <= last; i++) pages.push(i);
            } else {
                let left = current - window;
                let right = current + window;
                if (left < 2) {
                    right += 2 - left;
                    left = 2;
                }
                if (right > last - 1) {
                    left -= right - (last - 1);
                    right = last - 1;
                }
                pages.push(1);
                if (left > 2) pages.push("...");
                for (
                    let i = Math.max(2, left);
                    i <= Math.min(last - 1, right);
                    i++
                )
                    pages.push(i);
                if (right < last - 1) pages.push("...");
                pages.push(last);
            }
            pages.forEach((page) => {
                if (page === "...") {
                    html +=
                        '<span aria-disabled="true"><span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5">...</span></span>';
                } else if (page === current) {
                    html +=
                        '<span aria-current="page"><span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">' +
                        page +
                        "</span></span>";
                } else {
                    html += `<a href="#" data-page="${page}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page ${page}">${page}</a>`;
                }
            });
            // Next button (desktop)
            if (pagination.current_page === pagination.last_page) {
                html += '<span aria-disabled="true" aria-label="Next">';
                html +=
                    '<span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5" aria-hidden="true">';
                html +=
                    '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>';
                html += "</span></span>";
            } else {
                html += `<a href="#" data-page="${
                    pagination.current_page + 1
                }" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Next">`;
                html +=
                    '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>';
                html += "</a>";
            }
            html += "</span></div></div></div></nav>";
        }
        $("#pagination-table").html(html);

        // Bind click event for AJAX pagination
        $("#pagination-table a[data-page]")
            .off("click")
            .on("click", function (e) {
                e.preventDefault();
                let page = $(this).data("page");
                let searchValue = $("#search-input").val();
                fetchPage(page, searchValue, entity, tableSelector);
            });
    }

    function fetchPage(page, searchValue, entity, tableSelector) {
        $.ajax({
            url: `/admin/table/${entity}?search=${encodeURIComponent(
                searchValue
            )}&page=${page}`,
            method: "GET",
            headers: { "X-Requested-With": "XMLHttpRequest" },
            dataType: "json",
            success: function (data) {
                // Bangun thead otomatis
                data.columns.shift();
                let tableHead = "<tr>";
                tableHead += '<th scope="col" class="px-6 py-3">No</th>';
                data.columns.forEach(function (col) {
                    tableHead += `<th scope="col" class="px-6 py-3">${col
                        .replace("_", " ")
                        .toUpperCase()}</th>`;
                });
                tableHead += "</tr>";
                $(`${tableSelector} thead`).html(
                    `<tr>${tableHead}</tr>`.replace("<tr><tr>", "<tr>")
                );

                // Bangun tbody otomatis
                let tableBody = "";
                if (data.data.length === 0) {
                    tableBody =
                        '<tr><td colspan="' +
                        (data.columns.length + 1) +
                        '" class="text-center py-8 text-gray-500">No records found.</td></tr>';
                } else {
                    $.each(data.data, function (index, item) {
                        tableBody +=
                            '<tr class="bg-white border-b hover:bg-gray-50 border-gray-200 transition duration-300 ease-in-out">';
                        tableBody += `<td class="px-6 py-4">${index + 1}</td>`;
                        data.columns.forEach(function (col) {
                            tableBody += `<td class="px-6 py-4">${item[col]}</td>`;
                        });
                        tableBody += "</tr>";
                    });
                }
                $(`${tableSelector} tbody`).html(tableBody);
                renderPagination(
                    data.pagination,
                    searchValue,
                    entity,
                    tableSelector
                );
            },
        });
    }

    function liveSearch(searchInput, entity, tableSelector) {
        $(searchInput).on("input", function () {
            let searchValue = $(this).val();
            $.ajax({
                url: `/admin/table/${entity}?search=${encodeURIComponent(
                    searchValue
                )}`,
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
                dataType: "json",
                success: function (data) {
                    // Bangun thead otomatis
                    data.columns.shift();
                    let tableHead = "<tr>";
                    tableHead += '<th scope="col" class="px-6 py-3">No</th>';
                    data.columns.forEach(function (col) {
                        tableHead += `<th scope="col" class="px-6 py-3">${col
                            .replace("_", " ")
                            .toUpperCase()}</th>`;
                    });
                    tableHead += "</tr>";
                    $(`${tableSelector} thead`).html(
                        `<tr>${tableHead}</tr>`.replace("<tr><tr>", "<tr>")
                    );

                    // Bangun tbody otomatis
                    let tableBody = "";
                    if (data.data.length === 0) {
                        tableBody =
                            '<tr><td colspan="' +
                            (data.columns.length + 1) +
                            '" class="text-center py-8 text-gray-500">No records found.</td></tr>';
                    } else {
                        $.each(data.data, function (index, item) {
                            tableBody +=
                                '<tr class="bg-white border-b hover:bg-gray-50 border-gray-200 transition duration-300 ease-in-out">';
                            tableBody += `<td class="px-6 py-4">${
                                index + 1
                            }</td>`;
                            data.columns.forEach(function (col) {
                                tableBody += `<td class="px-6 py-4">${item[col]}</td>`;
                            });
                            tableBody += "</tr>";
                        });
                    }
                    $(`${tableSelector} tbody`).html(tableBody);
                    renderPagination(
                        data.pagination,
                        searchValue,
                        entity,
                        tableSelector
                    );
                },
            });
        });
    }

    liveSearch("#search-input", "customer", "#customer-table");
    liveSearch("#search-input", "seller", "#seller-table");
    liveSearch("#search-input", "store", "#store-table");
    liveSearch("#search-input", "product", "#product-table");

    // --- Public Home Live Search ---
    const $input = $("#live-search-input");
    const $resultsBox = $("#live-search-results");
    const $form = $("#live-search-form");
    let timeout = null;

    $input.on("input", function () {
        clearTimeout(timeout);
        const query = $(this).val().trim();
        if (query.length < 1) {
            $resultsBox.addClass("hidden").empty();
            return;
        }
        timeout = setTimeout(() => {
            $.get(
                `/live-search?q=${encodeURIComponent(query)}`,
                function (data) {
                    let html = "";
                    if (data.products.length) {
                        html += `
                    <div class="px-4 pt-3 pb-2 flex items-center gap-2 text-green-700 font-bold text-sm border-b bg-white sticky top-0 z-10">
                        <i class="ri-shopping-bag-3-line text-lg"></i> Produk
                    </div>`;
                        html += data.products
                            .map(
                                (item) => `
                        <a href="/product/${
                            item.slug
                        }" class="flex items-center gap-3 p-3 hover:bg-green-50 transition last:border-b-0 group">
                            <div class="flex-shrink-0 w-14 h-14 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                <img src="${
                                    item.image_url ||
                                    "https://via.placeholder.com/56x56?text=No+Image"
                                }" class="w-full h-full object-cover" alt="${
                                    item.name
                                }">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-900 truncate group-hover:text-green-700 text-base">${
                                    item.name
                                }</div>
                                <div class="text-xs text-gray-500 truncate">${
                                    item.category?.name || ""
                                } &bull; ${item.store?.name || ""}</div>
                                <div class="text-xs text-gray-400 truncate">${
                                    item.description || ""
                                }</div>
                            </div>
                            <span class="hidden sm:inline-block bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full ml-2">Produk</span>
                        </a>
                    `
                            )
                            .join("");
                    }
                    // if (data.categories.length) {
                    //     html += `
                    // <div class="px-4 pt-3 pb-2 flex items-center gap-2 text-blue-700 font-bold text-sm border-b bg-white sticky top-0 z-10">
                    //     <i class="ri-price-tag-3-line text-lg"></i> Kategori
                    // </div>`;
                    //     html += data.categories
                    //         .map(
                    //             (cat) => `
                    //     <a href="/category/${
                    //         cat.slug
                    //     }" class="flex items-center gap-3 p-3 hover:bg-blue-50 transition last:border-b-0 group">
                    //         <div class="flex-shrink-0 w-14 h-14 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                    //             <img src="${
                    //                 cat.image_url ||
                    //                 "https://via.placeholder.com/56x56?text=No+Image"
                    //             }" class="w-full h-full object-cover" alt="${
                    //                 cat.name
                    //             }">
                    //         </div>
                    //         <div class="flex-1 min-w-0">
                    //             <div class="font-semibold text-gray-900 truncate group-hover:text-blue-700 text-base">${
                    //                 cat.name
                    //             }</div>
                    //             <div class="text-xs text-gray-400 truncate">${
                    //                 cat.slug
                    //             }</div>
                    //         </div>
                    //         <span class="hidden sm:inline-block bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-0.5 rounded-full ml-2">Kategori</span>
                    //     </a>
                    // `
                    //         )
                    //         .join("");
                    // }
                    if (data.stores.length) {
                        html += `
                    <div class="px-4 pt-3 pb-2 flex items-center gap-2 text-orange-700 font-bold text-sm border-b bg-white sticky top-0 z-10">
                        <i class="ri-store-2-line text-lg"></i> Toko
                    </div>`;
                        html += data.stores
                            .map(
                                (store) => `
                        <a href="/store/${
                            store.slug
                        }" class="flex items-center gap-3 p-3 hover:bg-orange-50 transition  last:border-b-0 group">
                            <div class="flex-shrink-0 w-14 h-14 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                <img src="${
                                    store.image_url ||
                                    "https://via.placeholder.com/56x56?text=No+Image"
                                }" class="w-full h-full object-cover" alt="${
                                    store.name
                                }">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-900 truncate group-hover:text-orange-700 text-base">${
                                    store.name
                                }</div>
                                <div class="text-xs text-gray-500 truncate">${
                                    store.address || ""
                                }</div>
                                <div class="text-xs text-gray-400 truncate">${
                                    store.description || ""
                                }</div>
                            </div>
                            <span class="hidden sm:inline-block bg-orange-100 text-orange-700 text-xs font-semibold px-2 py-0.5 rounded-full ml-2">Toko</span>
                        </a>
                    `
                            )
                            .join("");
                    }
                    if (!html)
                        html =
                            '<div class="p-6 text-gray-400 text-center">Tidak ada hasil ditemukan.</div>';
                    $resultsBox.html(html).removeClass("hidden");
                },
                "json"
            );
        }, 300);
    });

    // Hide results on blur (optional)
    $input.on("blur", function () {
        setTimeout(() => $resultsBox.addClass("hidden"), 200);
    });
    $input.on("focus", function () {
        if ($resultsBox.html().trim() !== "") $resultsBox.removeClass("hidden");
    });

    // Submit fallback (optional)
    $form.on("submit", function (e) {
        // Optional: window.location.href = `/search?q=${encodeURIComponent($input.val())}`;
        // e.preventDefault();
    });
});
