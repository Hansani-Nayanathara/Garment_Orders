
<?php
// Start the session
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit;
}

// Retrieve username from the session
$username = $_SESSION['username'];

$customer_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : '';


// Check if the order_id is set in the session
if (isset($_SESSION['order_id'])) {
    $order_id = $_SESSION['order_id'];
} 

if (isset($_SESSION['product_type'])) {
    $order_id = $_SESSION['product_type'];
} 


// Retrieve and display the error message from the session (if any)
$error_message2 = '';
if (isset($_SESSION['error_message2'])) {
    $error_message2 = $_SESSION['error_message2'];
    unset($_SESSION['error_message2']); // Clear the error message from the session
}
// Retrieve data from the session
$invoice_details = isset($_SESSION['invoice_details']) ? $_SESSION['invoice_details'] : [];
$customer_details = isset($_SESSION['customer_details']) ? $_SESSION['customer_details'] : [];
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';

// Clear session data
unset($_SESSION['invoice_details']);
unset($_SESSION['customer_details']);
unset($_SESSION['error_message']);

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
   
    

   
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>User and Address Form</title>
    <style>

        

        .content-div {
            display: none;
            padding: 20px;
            border: 1px solid #ddd;
            margin: 10px 0;
        }


		#AdultTshirtDiv {
		    margin-top: 20px;
		    display: none; /* Initially hidden */
		}

		#AdultShortBottomDiv{
			margin-top: 20px;
		    display: none; /* Initially hidden */
		}

		#KidsTshirtDiv {
		    margin-top: 20px;
		    display: none; /* Initially hidden */
		}

		#KidsShortBottomDiv{
			margin-top: 20px;
		    display: none; /* Initially hidden */
		}

		#OthersDiv{
			margin-top: 20px;
		    display: none; /* Initially hidden */
		}


        body {
            font-family: Arial, sans-serif;
        }

        table {
        	margin: 20px; 
            width: 80%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
        }

        th {
            background-color: #f4f4f4;
        }

        label{
        	 display: inline-block;
            width:250px; /* Set a fixed width for labels */
            text-align: left; /* Optional: right-align text within the label */
            margin-right: 10px;
        }

        input{
        	width:250px;
        }

.error { color: red; }

.error-message { color: red; }
        
    </style>

   


</head>
<body>

    <h2>Welcome to Garment Orders, <?php echo htmlspecialchars($username); ?>!</h2>
    <p>You are successfully logged in. Now you can view or place orders.</p>

    <!-- Add your garment order form and details here -->
    
    <a href="logout.php">Logout</a><br><br><br>

<!-- Search Invoice Details -->
<form method="POST" action="ProcessForm.php">
    <label>Input invoice number:</label>
    <input type="text" name="invoice_number" value="<?php echo htmlspecialchars(isset($_POST['invoice_number']) ? $_POST['invoice_number'] : ''); ?>">
    <button type="submit" name="search_invoice">Search</button>
</form>

<?php if (!empty($error_message)): ?>
    <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
<?php endif; ?>

<?php if (!empty($invoice_details) && !empty($customer_details)): ?>
    <div class="results">
        <h2>Invoice Details</h2>
        <table>
            <tr>
                <th>Invoice Number</th>
                <th>Total Invoice Amount</th>
                <th>Advanced Paid</th>
                <th>Estimated Delivery Date</th>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($invoice_details['invoice_number']); ?></td>
                <td><?php echo htmlspecialchars($invoice_details['total_invoice_amount']); ?></td>
                <td><?php echo htmlspecialchars($invoice_details['advance_paid']); ?></td>
                <td><?php echo htmlspecialchars($invoice_details['estimated_delivery_date']); ?></td>
            </tr>
        </table>

        <h2>Customer Details</h2>
        <table>
            <tr>
                <th>Customer ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Mobile Number</th>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($customer_details['customer_id']); ?></td>
                <td><?php echo htmlspecialchars($customer_details['name']); ?></td>
                <td><?php echo htmlspecialchars($customer_details['address']); ?></td>
                <td><?php echo htmlspecialchars($customer_details['mobile_number']); ?></td>
            </tr>
        </table>
    </div>
<?php endif; ?>



<!--Customer Details-->

<form id="userForm" method="POST" action="CustomerSubmit.php">
    <h2>Customer Details</h2>

    <label for="mobile">Mobile number :</label>
    <input type="text" id="MobileNumber" name="MobileNumber" required>
    <span id="mobile-error" class="error"></span><br><br>

    <label for="name">Name :</label>
    <input type="text" id="Name" name="Name" required><br><br>

    <label for="address">Address :</label>
    <input type="text" id="Address" name="Address" required><br><br>

    <label for="date">Estimated delivery date :</label>
    <input type="date" id="date" name="date"><br><br>

    <button type="submit">Submit</button>


</form>

<!-- Error message placeholder, will be displayed if redirected from CustomerSubmit.php -->
    <?php if (isset($_GET['error_message2'])): ?>
        <div class="error-message">
            <p><?php echo htmlspecialchars($_GET['error_message2']); ?></p>
        </div>
    <?php endif; ?>

<!--Order Details-->


    <h2>Order Details</h2>

<button id="AdultTshirt" onclick="setProductType('Adult T shirt')">Adult T shirt</button>
<button id="KidsTshirt" onclick="setProductType('Kids T shirt')">Kids T shirt</button>
<button id="AdultShortBottom" onclick="setProductType('Adult Short Bottom')">Adult short and bottom</button>
<button id="KidsShortBottom" onclick="setProductType('Kids Short Bottom')">Kids short and bottom</button>
<button id="Others" onclick="setProductType('Others')">Others</button>

<form method="POST" action="Adult_tshirt.php" enctype="multipart/form-data">
    <div>
        <div id="AdultTshirtDiv">
            <h2>Category : Adult T-shirt</h2>
            <table>
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Sleeve</th>
                        <th>Total Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- XS row -->
                    <tr>
                        <td>XS</td>
                        <td>
                            <div class="sleeve-container">
                                <label>Full</label>
                                <input type="number" name="xs_full" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="XS Full Sleeve">More Details</a>
                                <br>
                                <label>Half</label>
                                <input type="number" name="xs_half" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="XS Half Sleeve">More Details</a>
                                <br>
                                <label>Sleeveless</label>
                                <input type="number" name="xs_sleeveless" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="XS Sleeveless">More Details</a>
                            </div>
                        </td>
                        <td><input type="number" name="xs_quantity" min="0" placeholder="0"></td>
                    </tr>

                    <!-- S row -->
                    <tr>
                        <td>S</td>
                        <td>
                            <div class="sleeve-container">
                                <label>Full</label>
                                <input type="number" name="s_full" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="S Full Sleeve">More Details</a>
                                <br>
                                <label>Half</label>
                                <input type="number" name="s_half" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="S Half Sleeve">More Details</a>
                                <br>
                                <label>Sleeveless</label>
                                <input type="number" name="s_sleeveless" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="S Sleeveless">More Details</a>
                            </div>
                        </td>
                        <td><input type="number" name="s_quantity" min="0" placeholder="0"></td>
                    </tr>

                    <!-- M row -->
                    <tr>
                        <td>M</td>
                        <td>
                            <div class="sleeve-container">
                                <label>Full</label>
                                <input type="number" name="m_full" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="M Full Sleeve">More Details</a>
                                <br>
                                <label>Half</label>
                                <input type="number" name="m_half" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="M Half Sleeve">More Details</a>
                                <br>
                                <label>Sleeveless</label>
                                <input type="number" name="m_sleeveless" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="M Sleeveless">More Details</a>
                            </div>
                        </td>
                        <td><input type="number" name="m_quantity" min="0" placeholder="0"></td>
                    </tr>

                    <!-- L row -->
                    <tr>
                        <td>L</td>
                        <td>
                            <div class="sleeve-container">
                                <label>Full</label>
                                <input type="number" name="l_full" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="L Full Sleeve">More Details</a>
                                <br>
                                <label>Half</label>
                                <input type="number" name="l_half" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="L Half Sleeve">More Details</a>
                                <br>
                                <label>Sleeveless</label>
                                <input type="number" name="l_sleeveless" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="L Sleeveless">More Details</a>
                            </div>
                        </td>
                        <td><input type="number" name="l_quantity" min="0" placeholder="0"></td>
                    </tr>

                    <!-- XL row -->
                    <tr>
                        <td>XL</td>
                        <td>
                            <div class="sleeve-container">
                                <label>Full</label>
                                <input type="number" name="xl_full" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="XL Full Sleeve">More Details</a>
                                <br>
                                <label>Half</label>
                                <input type="number" name="xl_half" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="XL Half Sleeve">More Details</a>
                                <br>
                                <label>Sleeveless</label>
                                <input type="number" name="xl_sleeveless" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="XL Sleeveless">More Details</a>
                            </div>
                        </td>
                        <td><input type="number" name="xl_quantity" min="0" placeholder="0"></td>
                    </tr>

                    <!-- 2XL row -->
                    <tr>
                        <td>2XL</td>
                        <td>
                            <div class="sleeve-container">
                                <label>Full</label>
                                <input type="number" name="2xl_full" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="2XL Full Sleeve">More Details</a>
                                <br>
                                <label>Half</label>
                                <input type="number" name="2xl_half" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="2XL Half Sleeve">More Details</a>
                                <br>
                                <label>Sleeveless</label>
                                <input type="number" name="2xl_sleeveless" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="2XL Sleeveless">More Details</a>
                            </div>
                        </td>
                        <td><input type="number" name="2xl_quantity" min="0" placeholder="0"></td>
                    </tr>

                    <!-- 3XL row -->
                    <tr>
                        <td>3XL</td>
                        <td>
                            <div class="sleeve-container">
                                <label>Full</label>
                                <input type="number" name="3xl_full" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="3XL Full Sleeve">More Details</a>
                                <br>
                                <label>Half</label>
                                <input type="number" name="3xl_half" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="3XL Half Sleeve">More Details</a>
                                <br>
                                <label>Sleeveless</label>
                                <input type="number" name="3xl_sleeveless" placeholder="0">
                                <a href="#" class="moreDetailsLink" data-product="3XL Sleeveless">More Details</a>
                            </div>
                        </td>
                        <td><input type="number" name="3xl_quantity" min="0" placeholder="0"></td>
                    </tr>

                </tbody>
            </table>
            
            <label for="image">Image of the design:</label>
            <input type="file" id="image" name="image"><br><br>
            <button type="submit">Submit</button>
        </div>
    </div>
</form>




<!-- ----------------------------------------------------------------------------------------------- -->
  <!-- Modal Structure -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModalLabel">Add More Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- Modal Body with Form -->
      <div class="modal-body">
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

          <!-- Add More Button -->
          <a href="#" id="addMoreBtn" class="btn btn-link">Add More</a><br><br>

          <!-- Tag Section -->
          <label>Tag :</label><br>
          <label><input type="checkbox" name="tag[]" value="Size"> Size</label>
          <label><input type="checkbox" name="tag[]" value="Brand_name"> Brand name</label>
          <label><input type="checkbox" name="tag[]" value="Promotion"> Promotion</label>
          <label><input type="checkbox" name="tag[]" value="Logo"> Logo</label><br><br>

          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- ----------------------------------------------------------------------------------------------- -->

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

	    <div id="KidsTshirtDiv">
	    	<h2>Category : Kids T shirt</h2>
	        <table>
	        <thead>
	            <tr>
	                <th>Size</th>
	                <th>Sleeve</th>
	                <th>Total Quantity</th>
	            </tr>
	        </thead>
	       <tbody>
	            <tr>
	                <td>XS</td>
	                <td>
	                    <div class="sleeve-container">
	                            <label>Full</label>
	                            <input type="number" name="xs_full" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="XS Full Sleeve">More Details</a>
								<br>
	                            <label>Half</label>
	                            <input type="number" name="xs_half" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="XS Half Sleeve">More Details</a>
								<br>
	                            <label>Sleeveless</label>
	                            <input type="number" name="xs_sleeveless" placeholder="0">
	                             <a href="#" class="moreDetailsLink" data-product="XS Sleeveless">More Details</a>
	                    </div>
	                </td>
	                <td><input type="number" name="xs_quantity" min="0" placeholder="0"></td>
	            </tr>
	            <tr>
	                <td>S</td>
	                <td>
	                    <div class="sleeve-container">
	                            <label>Full</label>
	                            <input type="number" name="s_full" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="S Full Sleeve">More Details</a>
								<br>
	                            <label>Half</label>
	                            <input type="number" name="s_half" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="S Half Sleeve">More Details</a>
								<br>
	                            <label>Sleeveless</label>
	                            <input type="number" name="s_sleeveless" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="S Sleeveless">More Details</a>
	                    </div>
	                </td>
	                <td><input type="number" name="xs_quantity" min="0" placeholder="0"></td>
	            </tr>
	            <tr>
	                <td>M</td>
	                <td>
	                   <div class="sleeve-container">
	                            <label>Full</label>
	                            <input type="number" name="m_full" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="m Full Sleeve">More Details</a>
								<br>
	                            <label>Half</label>
	                            <input type="number" name="m_half" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="m Half Sleeve">More Details</a>
								<br>
	                            <label>Sleeveless</label>
	                            <input type="number" name="m_sleeveless" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="m Sleeveless">More Details</a>
	                    </div>
	                </td>
	                <td><input type="number" name="xs_quantity" min="0" placeholder="0"></td>
	            </tr>
	            <tr>
	                <td>L</td>
	                <td>
	                    	                    <div class="sleeve-container">
	                            <label>Full</label>
	                            <input type="number" name="l_full" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="l Full Sleeve">More Details</a>
								<br>
	                            <label>Half</label>
	                            <input type="number" name="l_half" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="l Half Sleeve">More Details</a>
								<br>
	                            <label>Sleeveless</label>
	                            <input type="number" name="l_sleeveless" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="l Sleeveless">More Details</a>
	                    </div>
	                </td>
	                <td><input type="number" name="xs_quantity" min="0" placeholder="0"></td>
	            </tr>
	            <tr>
	                <td>XL</td>
	                <td>
	                    <div class="sleeve-container">
	                            <label>Full</label>
	                            <input type="number" name="xl_full" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="xl Full Sleeve">More Details</a>
								<br>
	                            <label>Half</label>
	                            <input type="number" name="xl_half" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="xl Half Sleeve">More Details</a>
								<br>
	                            <label>Sleeveless</label>
	                            <input type="number" name="xl_sleeveless" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="xl Sleeveless">More Details</a>
	                    </div>
	                </td>
	                <td><input type="number" name="xs_quantity" min="0" placeholder="0"></td>
	            </tr>
	            <tr>
	                <td>2XL</td>
	                <td>
	                    <div class="sleeve-container">
	                            <label>Full</label>
	                            <input type="number" name="2xl_full" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="2xl Full Sleeve">More Details</a>
								<br>
	                            <label>Half</label>
	                            <input type="number" name="2xl_half" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="2xl Half Sleeve">More Details</a>
								<br>
	                            <label>Sleeveless</label>
	                            <input type="number" name="2xl_sleeveless" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="2xl Sleeveless">More Details</a>
	                    </div>
	                </td>
	                <td><input type="number" name="xs_quantity" min="0" placeholder="0"></td>
	            </tr>
	            <tr>
	                <td>3XL</td>
	                <td>
	                    <div class="sleeve-container">
	                            <label>Full</label>
	                            <input type="number" name="3xl_full" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="3xl Full Sleeve">More Details</a>
								<br>
	                            <label>Half</label>
	                            <input type="number" name="3xl_half" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="3xl Half Sleeve">More Details</a>
								<br>
	                            <label>Sleeveless</label>
	                            <input type="number" name="3xl_sleeveless" placeholder="0">
	                            <a href="#" class="moreDetailsLink" data-product="3xl Sleeveless">More Details</a>
	                    </div>
	                </td>
	               <td><input type="number" name="xs_quantity" min="0" placeholder="0"></td>
	            </tr>
	        </tbody>
	    </table>
	            <label for="image">Image of the design:</label>
                <input type="file" id="image" name="image"><br><br>
                <button type="submit">Submit</button>
                <button type="custom">Custom</button>
	    </div>

	    <div id="KidsShortBottomDiv">
	    	<h2>Category : Kids Shorts and Bottoms</h2>
	        <form id="orderForm" action="storeOrder.php" method="post" enctype="multipart/form-data">
	        	 <input type="hidden" name="customer_id" value="<?php echo $_SESSION['customer_id']; ?>">
    <table>
        <thead>
            <tr>
                <th>Size</th>
                <th>Long</th>
                <th>Total Quantity</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>XS</td>
                <td><input type="text" name="length[xs]"></td>
                <td><input type="number" name="total_qty[xs]" min="0" placeholder="0"></td>
            </tr>
            <tr>
                <td>S</td>
                <td><input type="text" name="length[s]"></td>
                <td><input type="number" name="total_qty[s]" min="0" placeholder="0"></td>
            </tr>
            <tr>
                <td>M</td>
                <td><input type="text" name="length[m]"></td>
                <td><input type="number" name="total_qty[m]" min="0" placeholder="0"></td>
            </tr>
            <tr>
                <td>L</td>
                <td><input type="text" name="length[l]"></td>
                <td><input type="number" name="total_qty[l]" min="0" placeholder="0"></td>
            </tr>
            <tr>
                <td>XL</td>
                <td><input type="text" name="length[xl]"></td>
                <td><input type="number" name="total_qty[xl]" min="0" placeholder="0"></td>
            </tr>
            <tr>
                <td>2XL</td>
                <td><input type="text" name="length[2xl]"></td>
                <td><input type="number" name="total_qty[2xl]" min="0" placeholder="0"></td>
            </tr>
            <tr>
                <td>3XL</td>
                <td><input type="text" name="length[3xl]"></td>
                <td><input type="number" name="total_qty[3xl]" min="0" placeholder="0"></td>
            </tr>
        </tbody>
    </table>
    <label for="image">Image of the design:</label>
    <input type="file" id="image" name="image"><br><br>
    <input type="hidden" id="productType" name="product_type" value="">
    <button type="submit" id="submitBtn">Submit</button>
</form>

</div>
</div>


	     <div id="AdultShortBottomDiv">
	    	<h2>Category : Adult Shorts and Bottoms</h2>
	        <form id="orderForm" action="storeOrderAdult.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="customer_id" value="<?php echo isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : ''; ?>">
        <table>
            <thead>
                <tr>
                    <th>Size</th>
                    <th>Length</th>
                    <th>Total Quantity</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>XS</td>
                    <td><input type="text" name="length[xs]"></td>
                    <td><input type="number" name="total_qty[xs]" min="0" placeholder="0"></td>
                </tr>
                <tr>
                    <td>S</td>
                    <td><input type="text" name="length[s]"></td>
                    <td><input type="number" name="total_qty[s]" min="0" placeholder="0"></td>
                </tr>
                <tr>
                    <td>M</td>
                    <td><input type="text" name="length[m]"></td>
                    <td><input type="number" name="total_qty[m]" min="0" placeholder="0"></td>
                </tr>
                <tr>
                    <td>L</td>
                    <td><input type="text" name="length[l]"></td>
                    <td><input type="number" name="total_qty[l]" min="0" placeholder="0"></td>
                </tr>
                <tr>
                    <td>XL</td>
                    <td><input type="text" name="length[xl]"></td>
                    <td><input type="number" name="total_qty[xl]" min="0" placeholder="0"></td>
                </tr>
                <tr>
                    <td>2XL</td>
                    <td><input type="text" name="length[2xl]"></td>
                    <td><input type="number" name="total_qty[2xl]" min="0" placeholder="0"></td>
                </tr>
                <tr>
                    <td>3XL</td>
                    <td><input type="text" name="length[3xl]"></td>
                    <td><input type="number" name="total_qty[3xl]" min="0" placeholder="0"></td>
                </tr>
            </tbody>
        </table>
        <label for="image">Image of the design:</label>
        <input type="file" id="image" name="image"><br><br>
        <input type="hidden" id="productType" name="product_type" value="AdultShortBottom">
        <button type="submit">Submit</button>
    </form>
</div>



	    <div id="OthersDiv">
    <h2>Category : Others</h2>



    <form id="othersForm" action="OthersOrder.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="customer_id" value="<?php echo isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : ''; ?>">

        <label for="size">Size:</label>
        <select id="size" name="size">
            <option value="xs">XS</option>
            <option value="s">S</option>
            <option value="m">M</option>
            <option value="l">L</option>
            <option value="xl">XL</option>
            <option value="2xl">2XL</option>
            <option value="3xl">3XL</option>
        </select>
        <br>

        <label for="type">Type:</label>
        <input type="text" id="type" name="type">
        <br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="1">
        <br>

        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
        <br>

        <label for="image">Image of the design:</label>
        <input type="file" id="image" name="image"><br><br>

        <button type="submit">Submit</button>
        <button type="button">Custom</button>
    </form>
</div>

				<br><br>



				<div>
					       <h2>Print Details</h2>

<form action="extra_details.php" method="post">

    <!-- Radio buttons for selecting if "Need name, number for short / bottom" -->
    <label>
        <input type="radio" name="need_bottoms" value="yes"> Yes
    </label>
    <label>
        <input type="radio" name="need_bottoms" value="no" checked> No
    </label>

    <table id="dataTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Number</th>
                <th>Size</th>
                <th>Sleeve</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" name="name[]" required></td>
                <td><input type="text" name="number[]" required></td>
                <td>
                    <select name="size[]" required>
                        <option value="XS">XS</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="2XL">2XL</option>
                        <option value="3XL">3XL</option>
                    </select>
                </td>
                <td>
                    <select name="sleeve[]" required>
                        <option value="full">Full</option>
                        <option value="half">Half</option>
                        <option value="sleeveless">Sleeveless</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>

    <button type="button" id="addRowBtn">Add Row</button>
    <button type="submit">Submit</button>
</form>
</div>
			<div>
				<h2>Invoice Details</h2>
				<form id="userForm"  method="POST" action="Invoice.php">

		        <label for="mobile">Total Invoice Amount  :</label>
		        <input type="text" id="MobileNumber" name="MobileNumber"><br><br>

		        <label for="name">Advanced paid :</label>
		        <input type="text" id="Name" name="Name" required><br><br>

		         <label for="date">Estimated delivery date :</label>
		        <input type="date" id="date" name="date" required><br><br>

			<button>Submit and Generate Summary</button>
	       
	    </form>

	</div>

	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<script>
 document.addEventListener('DOMContentLoaded', function() {
        const addRowBtn = document.getElementById('addRowBtn');
        const tableBody = document.getElementById('dataTable').querySelector('tbody');

        // Function to add a new row
        function addRow() {
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td><input type="text" name="name[]" required></td>
                <td><input type="text" name="number[]" required></td>
                <td>
                    <select name="size[]" required>
                        <option value="XS">XS</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="2XL">2XL</option>
                        <option value="3XL">3XL</option>
                    </select>
                </td>
                <td>
                    <select name="sleeve[]" required>
                        <option value="full">Full</option>
                        <option value="half">Half</option>
                        <option value="sleeveless">Sleeveless</option>
                    </select>
                </td>
            `;

            tableBody.appendChild(newRow);
        }

        // Add event listener to the "Add Row" button
        addRowBtn.addEventListener('click', addRow);
    });
		//model and 

		document.addEventListener('DOMContentLoaded', function() {
		    const addressModal = document.getElementById('addMoreBtn');

		    // Ensure the modal is hidden when the page is loaded
		    addressModal.style.display = 'none';

		    // Attach click event to all "More Details" links
		    document.querySelectorAll('.moreDetailsLink').forEach(function(link) {
		        link.addEventListener('click', function(event) {
		            event.preventDefault();
		            // Get the product name from the data-product attribute
		            const product = this.getAttribute('data-product');
		            // Update the modal title with the product name
		           // document.getElementById('productTitle').textContent = product + " Details";
		            // Show the modal
		            addressModal.style.display = 'flex';
		        });
		    });

		    // Attach click event to the close button to hide the modal
		    document.getElementById('addMoreBtn').addEventListener('click', function() {
		        addressModal.style.display = 'none';
		    });
		});



        /////////////////////////////////////////////////////////////////////////////////////////////////////////
		//Add more
		document.getElementById('addMoreBtn').addEventListener('click', function(event) {
		        event.preventDefault();
		        
		        // Get the container where new blocks will be added
		        const fieldsContainer = document.getElementById('fieldsContainer');

		        // Clone the first block of form elements
		        const newFieldBlock = fieldsContainer.querySelector('.fieldBlock').cloneNode(true);

		        // Update the name attributes to be unique
		        const radioButtons = newFieldBlock.querySelectorAll('input[type="radio"]');
		        radioButtons.forEach((radio, index) => {
		            radio.name = `yes_no_${fieldsContainer.children.length + 1}_${index + 1}`;
		        });

		        // Clear the input values (optional)
		        newFieldBlock.querySelectorAll('input[type="text"], input[type="number"]').forEach(input => {
		            input.value = '';
		        });

		        // Append the new form block to the container
		        fieldsContainer.appendChild(newFieldBlock);
		    });


		    // Button click event listeners
		    document.getElementById('AdultTshirt').addEventListener('click', function(event) {
		        event.preventDefault();
		        document.getElementById('AdultTshirtDiv').style.display = 'block';
		    });

		    document.getElementById('AdultShortBottom').addEventListener('click', function(event) {
		        event.preventDefault();
		        document.getElementById('AdultShortBottomDiv').style.display = 'block';
		    });

		    document.getElementById('KidsTshirt').addEventListener('click', function(event) {
		        event.preventDefault();
		        document.getElementById('KidsTshirtDiv').style.display = 'block';
		    });

		    document.getElementById('KidsShortBottom').addEventListener('click', function(event) {
		        event.preventDefault();
		        document.getElementById('KidsShortBottomDiv').style.display = 'block';
		    });

		    document.getElementById('Others').addEventListener('click', function(event) {
		        event.preventDefault();
		        document.getElementById('OthersDiv').style.display = 'block';
		    });

		     function displayError(message) {
            const errorContainer = document.getElementById('error-message');
            errorContainer.textContent = message;
        }

        window.onload = function() {
            <?php if (!empty($error_message)): ?>
                displayError("<?php echo $error_message; ?>");
            <?php endif; ?>
        }

         $(document).ready(function() {
        $("#MobileNumber").on('input', function() {
            var mobileNumber = $(this).val();

            if (mobileNumber.length === 10) {
                $.ajax({
                    url: 'CustomerDetails.php', // Your PHP file for handling the check
                    type: 'POST',
                    data: { check_mobile: true, mobile_number: mobileNumber },
                    success: function(response) {
                        if(response === 'exists') {
                            $("#mobile-error").text("This mobile number with already exists in the database.");
                        } else {
                            $("#mobile-error").text("");
                        }
                    }
                });
            } else {
                $("#mobile-error").text("");
            }
        });
    });


    function setProductType(type) {
        document.getElementById('productType').value = type;
    }


	    </script>

	    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
   
</body>
</html>
