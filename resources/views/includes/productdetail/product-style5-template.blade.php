<template id="product-detail-section">

    <div class="container">
        <div class="product-main">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="row">

                        <div class="col-12 col-lg-4">
                            <div class="slider-wrapper slider-banner pd2">
                                <div class="slider-for">
                                    <a class="slider-for__item ex1 fancybox-button product-detail-section-image-link"
                                        href="" data-fancybox-group="fancybox-button"
                                        title="Lorem ipsum dolor sit amet">
                                        <img class="product-detail-section-image" src="" alt="Zoom Image" />
                                    </a>

                                    {{-- <a class="slider-for__item ex1 fancybox-button" href="./images/gallery/preview/banner_2.png" data-fancybox-group="fancybox-button" title="Lorem ipsum dolor sit amet">
                          <img src="./images/gallery/preview/banner_2.png" alt="Zoom Image" />
                        </a>

                        <a class="slider-for__item ex1 fancybox-button" href="/images/gallery/preview/banner_3.png" data-fancybox-group="fancybox-button" title="Lorem ipsum dolor sit amet">
                          <img src="./images/gallery/preview/banner_3.png" alt="Zoom Image" />
                        </a>
                        <a class="slider-for__item ex1 fancybox-button" href="./images/gallery/preview/banner_4.png" data-fancybox-group="fancybox-button" title="Lorem ipsum dolor sit amet">
                          <img src="./images/gallery/preview/banner_4.png" alt="Zoom Image" />
                        </a> --}}

                                </div>

                                <div class="slider-nav">
                                    <div class="slider-nav__item">
                                        <img class="product-detail-section-image" src="" alt="Zoom Image" />
                                    </div>

                                    {{-- <div class="slider-nav__item">
                          <img src="./images/gallery/preview/banner_2.png" alt="Zoom Image" />
                        </div>

                        <div class="slider-nav__item">
                          <img src="./images/gallery/preview/banner_3.png" alt="Zoom Image" />
                        </div>
                        <div class="slider-nav__item">
                            <img src="./images/gallery/preview/banner_4.png" alt="Zoom Image" />
                          </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <span class="pre-tag new-tag">new</span>
                                    <h5 class="pro-title">Stylish Necklace Women Heart</h5>

                                    <div class="price product-card-price">
                                    </div>
                                    <div class="pro-rating">
                                        <fieldset class="disabled-ratings display-rating">
                                        </fieldset>
                                        <a href="#review" class="btn-link review-count"></a>
                                    </div>

                                    <div class="pro-infos">
                                        <div class="pro-single-info"><b>Product ID :</b><span
                                                class="product-detail-section-product-id"></span></div>
                                        <div class="pro-single-info"><b>Categroy :</b><a href="javascript:void(0)"
                                                class="product-detail-section-cateogory-link"></a></div>
                                        <input type="hidden" id="product_combination_id" />

                                    </div>

                                    <div class="pro-options">

                                    </div>




                                    <div class="pro-counter">
                                        <div class="input-group item-quantity">

                                            <input type="text" id="quantity-input" name="quantity"
                                                class="form-control" value="1">

                                            <span class="input-group-btn">
                                                <button type="button" class="quantity-plus btn" data-type="plus"
                                                    data-field="">
                                                    <i class="fas fa-plus"></i>
                                                </button>

                                                <button type="button" class="quantity-minus btn" data-type="minus"
                                                    data-field="">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </span>
                                        </div>
                                        <button type="button"
                                            class="btn btn-secondary btn-lg swipe-to-top add-to-cart">Add to
                                            Cart</button>


                                    </div>
                                    <div class="pro-sub-buttons">
                                        <div class="buttons">
                                            <button type="button" class="btn  btn-link wishlist-icon"
                                                style="padding-left: 0;"><i class="fas fa-heart"></i>Add to
                                                Wishlist</button>
                                            <button type="button" class="btn btn-link compare-icon"><i
                                                    class="fas fa-align-right"></i>Add to Compare</button>
                                        </div>
                                        <!-- AddToAny BEGIN -->
                                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                            <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                                            <a class="a2a_button_facebook"></a>
                                            <a class="a2a_button_twitter"></a>
                                            <a class="a2a_button_email"></a>
                                        </div>
                                        <script async src="https://static.addtoany.com/menu/page.js"></script>
                                        <!-- AddToAny END -->

                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="nav nav-pills" role="tablist">
                                        <a class="nav-link nav-item  active" href="#description" id="description-tab"
                                            data-toggle="pill" role="tab">Description</a>
                                        {{-- <a class="nav-link nav-item " href="#additionalInfo" id="additional-info-tab"
                                            data-toggle="pill" role="tab">Additional information</a> --}}
                                        <a class="nav-link nav-item" href="#review" id="review-tab" data-toggle="pill"
                                            role="tab">Reviews</a>
                                    </div>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade active show description"
                                            id="description" aria-labelledby="description-tab">

                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="additionalInfo"
                                            aria-labelledby="additional-info-tab">
                                            <table class="table table-striped table-borderless">

                                                <tbody>
                                                    <tr>
                                                        <th scope="row">Brand Name:</th>
                                                        <td>lindoMetals</td>

                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Metals Type:</th>
                                                        <td>Silver</td>

                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Main Stone:</th>
                                                        <td>Pearl</td>

                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Style:</th>
                                                        <td>Trendy</td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade " id="review"
                                            aria-labelledby="review-tab">
                                            <div class="reviews">
                                                <div class="review-bubbles">
                                                    <div class="review-bubble-single">
                                                        <div class="review-bubble-bg">
                                                            <div class="pro-rating">
                                                                <fieldset class="ratings">
                                                                    <div class="rating"></div>
                                                                    <div class='rating-stars text-center'>
                                                                        <ul id='stars'>
                                                                            <li class='star' title='Poor'
                                                                                data-value='1'>
                                                                                <i class='fa fa-star fa-fw'></i>
                                                                            </li>
                                                                            <li class='star' title='Fair'
                                                                                data-value='2'>
                                                                                <i class='fa fa-star fa-fw'></i>
                                                                            </li>
                                                                            <li class='star' title='Good'
                                                                                data-value='3'>
                                                                                <i class='fa fa-star fa-fw'></i>
                                                                            </li>
                                                                            <li class='star' title='Excellent'
                                                                                data-value='4'>
                                                                                <i class='fa fa-star fa-fw'></i>
                                                                            </li>
                                                                            <li class='star' title='WOW!!!'
                                                                                data-value='5'>
                                                                                <i class='fa fa-star fa-fw'></i>
                                                                            </li>
                                                                        </ul>
                                                                    </div>

                                                                </fieldset>
                                                                <input type="hidden" id="selected_rating" />
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>
                                                <div class="write-review">
                                                    <h2>Write a Review</h2>
                                                    <div class="from-group row mb-3">
                                                        <div class="col-12"> <label for="title">Review
                                                                Title</label></div>
                                                        <div class="input-group col-12">

                                                            <input type="text" class="form-control" id="title"
                                                                placeholder="Title of Review">
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                    <div class="from-group row mb-3">
                                                        <div class="col-12"> <label for="comment">Review
                                                                Body</label></div>
                                                        <div class="input-group col-12">

                                                            <textarea class="form-control" id="comment"
                                                                placeholder="Write Your Review"></textarea>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                    <div class="from-group">
                                                        <button type="button" class="btn btn-secondary swipe-to-top"
                                                            onclick="productReview()">Submit</button>

                                                    </div>
                                                </div>
                                                <div class="review-bubbles">
                                                    <h2>
                                                        Customer Reviews
                                                    </h2>
                                                    <div id="review-rating-show">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- <div class="col-12 col-lg-2">
                            <div class="banner-full slider-pcontent">
                                <h5>Best Sellers*</h5>
                                <div class="product-carousel-js5">
                                    <div class="">
                                        <div class="product">
                                            <article>
                                                <div class="thumb">
                                                    <div class="badges">
                                                        <span class="badge badge-danger">50%</span>
                                                        <span class="badge badge-info">New</span>
                                                    </div>


                                                    <img class="img-fluid"
                                                        src="images/product_images/product_image_1.png"
                                                        alt="Modern Single Sofa">
                                                </div>
                                            </article>
                                        </div>

                                        <div class="product">
                                            <article>
                                                <div class="thumb">
                                                    <div class="badges">
                                                        <span class="badge badge-danger">50%</span>
                                                        <span class="badge badge-success">featured</span>
                                                    </div>
                                                    <img class="img-fluid"
                                                        src="images/product_images/product_image_1.png"
                                                        alt="Modern Single Sofa">
                                                </div>

                                            </article>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="product">
                                            <article>
                                                <div class="thumb">
                                                    <div class="badges">
                                                        <span class="badge badge-danger">50%</span>
                                                        <span class="badge badge-info">New</span>
                                                    </div>
                                                    <img class="img-fluid"
                                                        src="images/product_images/product_image_1.png"
                                                        alt="Modern Single Sofa">
                                                </div>
                                            </article>
                                        </div>
                                        <div class="product">
                                            <article>
                                                <div class="thumb">
                                                    <div class="badges">
                                                        <span class="badge badge-danger">50%</span>
                                                    </div>
                                                    <img class="img-fluid"
                                                        src="images/product_images/product_image_1.png"
                                                        alt="Modern Single Sofa">
                                                </div>
                                            </article>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>


        </div>
    </div>

    </div>
</template>

<template id="review-rating-template">
    <div class="review-bubble-single">
        <div class="review-bubble-bg">
            <div class="pro-rating">

                <fieldset class="ratings">

                    <input type="radio" id="star05" name="rating0" value="5" class="rating review-rating5">
                    <label class="full" for="star05" title="Awesome0 - 5 stars"></label>


                    <input type="radio" id="star04" name="rating0" value="4" class="rating review-rating4">
                    <label class="full" for="star04" title="Pretty0 good - 4 stars"></label>

                    <input type="radio" id="star03" name="rating0" value="3" class="rating review-rating3">
                    <label class="full" for="star03" title="Pretty0 good - 3 stars"></label>

                    <input type="radio" id="star02" name="rating0" value="2" class="rating review-rating2">
                    <label class="full" for="star02" title="Meh0 - 2 stars"></label>

                    <input type="radio" id="star01" name="rating0" value="1" class="rating review-rating1">
                    <label class="full" for="star01" title="Meh0 - 1 stars"></label>
                </fieldset>
            </div>
            <h4 class="review-title"></h4>
            <span class="review-date"></span>
            <p class="review-comment"></p>
        </div>
    </div>
</template>
