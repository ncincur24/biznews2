<?php 
    session_start();
    include "connection/database.php";    
    include "models/functions.php";  
    $categories = selectAll("category");
    include_once "includes/head.php"; 
?>
    <!-- Contact Start -->
    <div class="container-fluid mt-5 pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">Contact Us For Any Queries</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-4 mb-3">
                        <div class="mb-4">
							<div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-map-marker-alt text-primary mr-2"></i>
                                    <h6 class="font-weight-bold mb-0">Our Office</h6>
                                </div>
                                <p class="m-0">123 Street, New York, USA</p>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-envelope-open text-primary mr-2"></i>
                                    <h6 class="font-weight-bold mb-0">Email Us</h6>
                                </div>
                                <p class="m-0">info@example.com</p>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-phone-alt text-primary mr-2"></i>
                                    <h6 class="font-weight-bold mb-0">Call Us</h6>
                                </div>
                                <p class="m-0">+012 345 6789</p>
                            </div>
                        </div>
                        <h6 class="text-uppercase font-weight-bold mb-3">Contact Us</h6>
                        <form id="form-contact">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control p-4" placeholder="Your Name" id="contactName" <?php if(isset($_SESSION['user'])):?>value="<?=$_SESSION['user']->name?>"<?php endif?> />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control p-4" placeholder="Your Email" id="contactEmail" <?php if(isset($_SESSION['user'])):?>value="<?=$_SESSION['user']->email?>"<?php endif?> />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="4" placeholder="Message" id="contactMessage"></textarea>
                            </div>
                            <div>
                                <input type="button" value="Send Message" class="btn btn-primary font-weight-semi-bold px-4" style="height: 50px;" id="btnContactMessage" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <!-- Footer Start -->
    <?php
    include_once("includes/footer.php");
?>