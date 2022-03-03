<?php
class HTML_Frontend
{
    public static function searchHeader($imgURL, $funcName, $link)
    {
        $xhtml = '
        <li class="onhover-div mobile-search">
            <div>
                <img src="' . $imgURL . 'search.png" onclick="' . $funcName . '" class="img-fluid blur-up lazyload" alt="">
                <i class="ti-search" onclick="' . $funcName . '"></i>
            </div>
            <div id="search-overlay" class="search-overlay">
                <div>
                    <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
                    <div class="overlay-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-12">
                                    <form action="' . $link . '" method="GET">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="search" id="search-input" placeholder="Tìm kiếm sách...">
                                        </div>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        ';
        return $xhtml;
    }

    
}


