<!-- TEST RULES -->
<div class="card shadow mb-4" id="test-rules">
    <div class="card-header">
        Test Rules
    </div>

    <div class="card-body">
        <div class="d-flex form-inline navbar-search mb-2">
            <div class="input-group w-75">
                <div class="input-group-prepend">
                    <span class="input-group-text">URL:</span>
                </div>
                <input type="text" id="test-url" class="form-control border" placeholder="https://shop.com/product/73625">
            </div>

            <button type="button" id="check-rules-btn" class="btn btn-primary shadow-sm w-auto ml-3">
                Check Rules
            </button>
        </div>

        <!-- SPINNER -->
        <div class="text-center mt-5 mb-4" style="display: none">
            <div class="spinner"></div>
        </div>

        <!-- RESULTS -->
        <div class="results-container" style="display: none">
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group title">
                        <label class="control-label">Title</label>
                        <div class="form-control text-truncate"></div>
                    </div>

                    <div class="form-group description">
                        <label class="control-label">Description</label>
                        <div class="form-control text-truncate"></div>
                    </div>

                    <div class="form-group price">
                        <label class="control-label">Price</label>
                        <div class="form-control"></div>
                    </div>

                    <div class="form-group in_stock_value">
                        <label class="control-label">In stock value</label>
                        <div class="form-control"></div>
                    </div>

                    <div class="form-group variants">
                        <label class="control-label">Variants</label>
                        <div class="variants-container"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group images">
                        <label class="control-label">Images</label>
                        <div class="images-container"></div>
                    </div>
                </div>

                <div class="form-group col specifications">
                    <label class="control-label">Specifications</label>
                    <div></div>
                </div>
            </div>
        </div>
    </div>
</div>
