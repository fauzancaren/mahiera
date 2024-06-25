<?php
    $CI =& get_instance();
    if( ! isset($CI))
    {
        $CI = new CI_Controller();
    }
    $CI->load->helper('url');
    $view = '
        <div class="ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image "  data-bg="'.base_url().'asset/image/mgs-erp/background/14.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ltn__breadcrumb-inner">
                            <h1 class="page-title">404 Page</h1>
                            <div class="ltn__breadcrumb-list">
                                <ul>
                                    <li><a href="index.html"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                                    <li>404</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ltn__404-area ltn__404-area-1 mb-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="error-404-inner text-center">
                            <div class="error-img mb-30">
                                <img src="'.base_url().'asset/image/mgs-erp/error-1.png" alt="#">
                            </div>
                            <h1 class="error-404-title d-none">404</h1>
                            <h2>Page Not Found! Page Not Found!</h2>
                            <!-- <h3>Oops! Looks like something going rong</h3> -->
                            <p>Oops! The page you are looking for does not exist. It might have been moved or deleted.</p>
                            <div class="btn-wrapper">
                                <a href="'.base_url().'" class="btn btn-transparent"><i class="fas fa-long-arrow-alt-left"></i> BACK TO HOME</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    include  __DIR__ . '/../../main/template.php';
?> 