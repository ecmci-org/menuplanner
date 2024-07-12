<?php include('includes/header.php') ?>

<div class="wrapper">
    <?php include('includes/sidebar.php') ?>

    <div class="main">
        <?php include('includes/navbar.php') ?>

        <div class="container py-4">
            <div class="controls mb-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <input type="text" id="meal-input" placeholder="Enter meal" class="form-control">
                    <input type="date" id="meal-date" class="form-control">
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button id="schedule-meal" class="btn btn-primary mb-2 mb-md-0">Schedule Meal</button>
                    <button id="auto-meal" class="btn btn-secondary">Auto Schedule Meal</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Modal for updating or deleting an event -->
        <div id="eventModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update/Delete Meal</h4>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="modal-meal-input" class="form-control" placeholder="Enter meal">
                        <input type="date" id="modal-meal-date" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="update-meal" class="btn btn-primary">Update Meal</button>
                        <button type="button" id="delete-meal" class="btn btn-danger">Delete Meal</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="Pages/schedule.js"></script>
<?php include('includes/footer.php') ?>