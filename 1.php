<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Design Specification Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<!-- Directly Visible Form -->
<div class="container mt-5">
    <h2>Add More Details</h2>
    <form id="designForm">
      <div id="fieldsContainer">
        <!-- First set of fields -->
        <div class="fieldBlock">
          <label>Collar:</label>
          <input type="text" name="collar[]" class="form-control" required><br>
          <label>Button:</label><br>
          <label><input type="radio" name="button_0" value="yes" required> Yes</label>
          <label><input type="radio" name="button_0" value="no"> No</label><br><br>
          <label>Quantity:</label>
          <input type="number" name="quantity[]" class="form-control" required><br>
        </div>
      </div>
      <a href="#" id="addMoreBtn" class="btn btn-link">Add More</a><br><br>
      <label>Tag :</label>
          <label><input type="checkbox" name="tag[]" value="Size"> Size</label>
          <label><input type="checkbox" name="tag[]" value="Brand_name"> Brand name</label>
          <label><input type="checkbox" name="tag[]" value="Promotion"> Promotion</label>
          <label><input type="checkbox" name="tag[]" value="Logo"> Logo</label><br><br>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Trigger modal when '.moreDetailsLink' is clicked
    $('.moreDetailsLink').click(function() {
      $('#detailsModal').modal('show');  // Show the modal when clicked
    });

    // Event listener for "Add More" button
    $('#addMoreBtn').click(function(e) {
      e.preventDefault(); // Prevent default action

      // Clone the fieldBlock and append it to the fieldsContainer
      let newFieldBlock = `
        <div class="fieldBlock">
          <label>Collar :</label>
          <input type="text" name="collar[]" required style="margin-bottom: 15px;"><br>
          <label>Button :</label><br>
          <label><input type="radio" name="button[]" value="yes"> Yes</label>
          <label><input type="radio" name="button[]" value="no"> No</label><br><br>
          <label>Quantity :</label>
          <input type="number" name="quantity[]" required style="margin-bottom: 15px;"><br>
        </div>`;

      $('#fieldsContainer').append(newFieldBlock);
    });


    // Handle form submission
    $('#designForm').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        let formData = $(this).serialize(); // Serialize form data for AJAX

        // Send data to PHP via AJAX
        $.ajax({
            url: 'design_specification.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                let result;
                try {
                    result = JSON.parse(response); // Try to parse the JSON response
                } catch (e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Response',
                        text: 'The server returned an invalid response.'
                    });
                    return;
                }

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data inserted successfully!'
                    });
                    $('#designForm')[0].reset(); // Reset the form on success
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while submitting the form.'
                });
            }
        });
    });
});
</script>
</body>
</html>
