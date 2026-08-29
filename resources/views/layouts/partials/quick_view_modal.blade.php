<div class="quick-view-overlay" id="quickViewModal">
    <div class="quick-view-container">
        <button class="quick-view-close" id="quickViewClose"><i class="fa-solid fa-xmark"></i></button>

        <div class="row g-4 align-items-center">
            <div class="col-md-6">
                <div class="quick-view-image-wrap">
                    <img id="qvImage" src="" alt="Plant Image">
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="care-pill care-pill-green" id="qvPetSafety"><i class="fa-solid fa-paw me-1"></i> Pet Friendly</span>
                    <span class="care-pill care-pill-purple" id="qvCareLevel"><i class="fa-solid fa-seedling me-1"></i> Easy Care</span>
                </div>

                <h3 class="fw-bold mb-2" id="qvTitle" style="font-family:'Playfair Display',serif">Monstera Deliciosa</h3>
                
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="rating text-warning" style="font-size:14px">★★★★★</div>
                    <span class="text-muted small" id="qvRatingText">(128 reviews)</span>
                </div>

                <div class="price mb-3" style="font-size:24px">
                    <strong id="qvPrice">Rs. 2,450</strong>
                    <del class="text-muted fs-6 ms-2" id="qvOldPrice">Rs. 2,900</del>
                </div>

                <p class="text-muted small mb-4" id="qvDesc">
                    A vibrant, lush botanical plant selected from local verified nurseries. Ideal for indoor spaces, apartments, and desks.
                </p>

                <!-- Pot Size Selector -->
                <div class="mb-4">
                    <label class="form-label fw-bold small">SELECT POT SIZE</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="size-btn active">Small (6")</button>
                        <button type="button" class="size-btn">Medium (10")</button>
                        <button type="button" class="size-btn">Large (14")</button>
                    </div>
                </div>

                <!-- Plant Specs Grid -->
                <div class="row g-2 mb-4 text-center">
                    <div class="col-6">
                        <div class="p-2 border rounded-3 bg-light">
                            <i class="fa-solid fa-sun text-warning me-1"></i>
                            <span class="small fw-bold" id="qvLight">Medium Light</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 border rounded-3 bg-light">
                            <i class="fa-solid fa-droplet text-primary me-1"></i>
                            <span class="small fw-bold" id="qvWater">Weekly Water</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary flex-grow-1 py-3 fw-bold add-btn" id="qvAddBtn" style="border-radius:14px;background:var(--green-900)">
                        <i class="fa-solid fa-plus me-1"></i> Add To Cart
                    </button>
                    <button class="wish icon-btn" style="width:50px;height:50px;border-radius:14px">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
