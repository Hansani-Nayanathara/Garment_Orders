 <!-- Modal Structure -->
 <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModalLabel">Add More Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form inside the modal -->
        <form id="addressForm" style="display: flex; flex-direction: column;">
          <label>Total Quantity:</label><br>
          <div id="fieldsContainer">
            <div class="fieldBlock">
              <label>Collar :</label>
              <input type="text" id="collar" name="collar" required style="margin-bottom: 15px;"><br>
              <label>Button :</label><br>
              <label><input type="radio" name="yes_no_1" value="yes"> Yes</label>
              <label><input type="radio" name="yes_no_1" value="no"> No</label><br><br>
              <label>Quantity :</label>
              <input type="number" id="quantity" name="quantity" required style="margin-bottom: 15px;"><br>
            </div>
          </div>
          <a href="#" id="addMoreBtn">Add More</a><br><br>
          
          <!-- Updated Tag section for multiple options -->
          <label>Tag :</label>
          <label><input type="checkbox" name="tag[]" value="Size"> Size</label>
          <label><input type="checkbox" name="tag[]" value="Brand_name"> Brand name</label>
          <label><input type="checkbox" name="tag[]" value="Promotion"> Promotion</label>
          <label><input type="checkbox" name="tag[]" value="Logo"> Logo</label><br><br>
          
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>






