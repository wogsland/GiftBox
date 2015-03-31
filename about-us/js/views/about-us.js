$(document).ready(function () {

    // about grid

    var $aboutGrid = $('.about-grid');
    var $aboutRow = $('.about-row');
    var $aboutCol = $('.about-col');
    var $aboutBox = $('[class*="about-box"]');

    $aboutGrid.each(function () {
        var $aboutGridRows = $(this).find($aboutRow).size();

        $aboutRow.each(function () {
            var $aboutRowCount = $(this).find($aboutCol).size();
            $(this).addClass('about-row-' + $aboutRowCount);
        });

        if ($aboutGridRows == 1) {
            $(this).find($aboutCol).each(function () {
                var $aboutColCount = $(this).find($aboutBox).size();
                $(this).addClass('about-col-' + $aboutColCount);
            });
        } else if ($aboutGridRows > 1) {
            $(this).find($aboutCol).each(function () {
                $(this).addClass('about-col-' + $aboutGridRows);
            });
        }
    });
});