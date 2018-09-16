<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSuggest">
    Add to the List
</button>

<!-- Modal -->
<div class="modal fade" id="modalSuggest" tabindex="-1" role="dialog" aria-labelledby="modalSuggestTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="modalSuggestTitle">Enter a place</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="suggestion" action="index.php" method="post">
                    <div class="form-group">
                        <label>Name of the Place</label>
                        <input type="text" class="form-control" maxlength="50" name="place" required autocomplete="off">
                    </div>
                    <div class="row">
                        <div class="col-md-8 form-group">
                            <label>City</label>
                            <input type="text" class="form-control" maxlength="50" name="city" required autocomplete="off" value="Rockford">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>State</label>
                            <select  class="form-control" name="state" required>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">District Of Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL" selected="selected">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="OK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Your Name (visible to others)</label>
                        <input type="text" class="form-control" maxlength="50" required name="recommender" autocomplete="off">
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="g-recaptcha" data-sitekey="6LeHw2EUAAAAAC5RFTT2Sz7udt8iRwNPETrnDwNZ"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-danger">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" form="suggestion" value="Submit">
            </div>
        </div>
    </div>
</div>