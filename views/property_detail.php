

    <!-- START NOO WRAPPER -->
    <div class="noo-wrapper">

      <!-- START NOO MAINBODY -->
      <div class="container noo-mainbody">
        <div class="noo-mainbody-inner">
          <div class="row clearfix">
 				  	<!-- START MAIN CONTENT -->
				  	<div class="noo-content col-xs-12 col-md-8">
				  		<!-- START ARTICLE PROPERTY -->
							<article class="property">
							  <h1 class="properties-header">
							    <?php if (intval($property['Display_Addrs_on_Pub_Web_Sites']) === 1): ?>
                    <?php
                        $address = $property['Street_Number'].' '.ucwords(strtolower($property['Street_Name'])).' '.ucfirst(strtolower($property['Street_Type']));
                        
                        if ($property['Suite_Number'] !== '')
                        {
                          $address = $property['Suite_Number'].' - '.$address;
                        }
                      ?>
							    <span id="civic_address"><?php echo $address; ?></span>
							    <?php endif; ?>
							    <small><?php echo $property['Neighbourhood']; ?>, <?php echo ucwords(strtolower($property['City_or_Town_Name'])); ?></small>
							  </h1>
							  
							  <?php if (!empty($property_images)): ?>
							  
                <div id="gallery" class="flexslider">
                  <ul class="slides">
                    <?php foreach ($property_images as $property_image): ?>
                		<li>
                	    <img src="<?php echo base_url().$property_image; ?>" alt="image" />
                		</li>
                		<?php endforeach; ?>
                  </ul>
                </div>
                  
                <div id="carousel" class="flexslider">
                  <ul class="slides">
                    <?php foreach ($property_images as $property_image): ?>
                		<li>
                	    <img src="<?php echo base_url().$property_image; ?>" alt="image" />
                		</li>
                		<?php endforeach; ?>
                  </ul>
                </div>						  
							  <?php endif; ?>
							  
								

							  <div class="property-summary">
							    <div class="row">
							      <div class="col-md-4">
							        <div class="property-detail">
							          <h4 class="property-detail-title">Property Detail</h4>
							          <div class="property-detail-content">
							            <div class="detail-field row">
							              <span class="col-xs-6 col-md-5 detail-field-label">Type</span>
							              <span class="col-xs-6 col-md-7 detail-field-value"><?php echo $property['Property_Type']; ?> / <?php echo $property['Type']; ?></span>

							              <span class="col-xs-6 col-md-5 detail-field-label">Style</span>
							              <span class="col-xs-6 col-md-7 detail-field-value"><?php echo $property['Style']; ?></span>

							              <span class="col-xs-6 col-md-5 detail-field-label">MLS&reg; #</span>
							              <span class="col-xs-6 col-md-7 detail-field-value" id="ml_number"><?php echo $property['ML_Number']; ?></span>
							              
							              <span class="col-xs-6 col-md-5 detail-field-label">Location</span>
							              <span class="col-xs-6 col-md-7 detail-field-value"><?php echo $property['Neighbourhood']; ?></span>

							              <span class="col-xs-6 col-md-5 detail-field-label">Price</span>
							              <span class="col-xs-6 col-md-7 detail-field-value">$ <?php echo number_format($property['CurrentPrice'], 0); ?></span>

							              <span class="col-xs-6 col-md-5 detail-field-label">Area</span>
							              <span class="col-xs-6 col-md-7 detail-field-value"><?php echo $property['Total_FloorLiv_Area_SF']; ?> sqft</span>

							              <span class="col-xs-6 col-md-5 detail-field-label">Bedrooms</span>
							              <span class="col-xs-6 col-md-7 detail-field-value"><?php echo $property['Total_Bedrooms']; ?></span>

							              <span class="col-xs-6 col-md-5 detail-field-label">Bathrooms</span>
							              <span class="col-xs-6 col-md-7 detail-field-value"><?php echo $property['Number_of_Total_Baths']; ?></span>

							              <span class="col-xs-6 col-md-5 detail-field-label">Year Built</span>
							              <span class="col-xs-6 col-md-7 detail-field-value"><?php echo $property['Year_Built']; ?></span>

							              <span class="col-xs-6 col-md-5 detail-field-label">Heating</span>
							              <span class="col-xs-6 col-md-7 detail-field-value"><?php echo $property['Heating']; ?></span>
							              
							              <span class="col-xs-6 col-md-5 detail-field-label">Title</span>
							              <span class="col-xs-6 col-md-7 detail-field-value"><?php echo $property['Title_to_Land']; ?></span>
							              
							            </div>
							          </div>
							        </div>
							      </div>
							      <div class="col-md-8">
							        <div class="property-desc">
							          <?php if ($open_houses): ?>
							          <h4 class="property-detail-title open-house">Open House</h4>
							          
							          <p><strong><?php echo ucwords(strtolower($open_houses['heading'])); ?></strong></p>
							          
							          <p><?php echo $open_houses['remarks']; ?></p>
							          
							          <ul>
							            <?php foreach ($open_houses['dates'] as $date): ?>
							            <li><?php echo date('l, F jS, Y', strtotime($date['date'])); ?> from <?php echo date('g:i A', strtotime('1999-12-31 '.substr_replace($date['start'], ':', 2, 0).':00')); ?> - <?php echo date('g:i A', strtotime('1999-12-31 '.substr_replace($date['end'], ':', 2, 0).':00')); ?></li>
							            <?php endforeach; ?>
							          </ul>
							          
							          <?php if (isset($open_houses['directions'])): ?>
							          <p><?php echo $open_houses['directions']; ?></p>
							          <?php endif; ?>
							          
							          <?php endif; ?>
							          <h4 class="property-detail-title">Property Description</h4>
							          <p><?php echo $property['Public_Remarks']; ?></p>
                        <p class="listed-by">Listed by <span itemscope itemtype="http://schema.org/RealEstateAgent"><span itemprop="name"><?php echo $property['Agent_1_First_Name']; ?> <?php echo $property['Agent_1_Last_Name']; ?></span></span>
                        <?php if (isset($property['Agent_2_First_Name']) && ($property['Agent_1_First_Name'] !== '')): ?>
                          and <span itemscope itemtype="http://schema.org/RealEstateAgent"><span itemprop="name"><?php echo $property['Agent_2_First_Name']; ?> <?php echo $property['Agent_2_Last_Name']; ?></span></span>
                        <?php endif; ?>
                        </p>
							        </div>
							      </div>
							    </div>
							  </div>

							  <div class="property-feature">
							    <h4 class="property-feature-title">Property Features</h4>
							    <div class="property-feature-content clearfix">
							      <?php foreach ($features as $feature): ?>
							      <div class="has">
							        <i class="fa fa-check-circle"></i> <?php echo $feature; ?>
                    </div>
							      <?php endforeach; ?>
							    </div>
							  </div>
							  
							  <?php if ($amenities): ?>
							  <div class="property-feature">
							    <h4 class="property-feature-title">Amenities</h4>
							    <div class="property-feature-content clearfix">
							      <?php foreach ($amenities as $amenity): ?>
							      <div class="has">
							        <i class="fa fa-check-circle"></i> <?php echo $amenity; ?>
                    </div>
							      <?php endforeach; ?>
							    </div>
							  </div>
							  <?php endif; ?>
							  
							  <?php if ($site_influences): ?>
							  <div class="property-feature">
							    <h4 class="property-feature-title">Site Influences</h4>
							    <div class="property-feature-content clearfix">
							      <?php foreach ($site_influences as $site_influence): ?>
							      <div class="has">
							        <i class="fa fa-check-circle"></i> <?php echo $site_influence; ?>
                    </div>
							      <?php endforeach; ?>
							    </div>
							  </div>
							  <?php endif; ?>
							  
							  <?php if ($flooring): ?>
							  <div class="property-feature">
							    <h4 class="property-feature-title">Flooring</h4>
							    <div class="property-feature-content clearfix">
							      <?php foreach ($flooring as $floor): ?>
							      <div class="has">
							        <i class="fa fa-check-circle"></i> <?php echo $floor; ?>
                    </div>
							      <?php endforeach; ?>
							    </div>
							  </div>
							  <?php endif; ?>
							  
							  <div class="property-feature">
							    <h4 class="property-feature-title">More Details</h4>
							    <div class="property-feature-content clearfix">
							      <table class="table table-striped table-condensed rooms">                    
  							      <?php if (isset($property['School_Division'])): ?>
                      <tr>
  							        <td>School Division</td>
                        <td><?php echo $property['School_Division']; ?></td>
                      </tr>
                      <?php endif; ?>

  							      <?php if (isset($property['HOA_Fee'])): ?>
                      <tr>
  							        <td>Condo Fee</td>
                        <td>$<?php echo number_format($property['HOA_Fee'], 2); ?></td>
                      </tr>
                      <tr>
  							        <td>Condo Fee Schedule</td>
                        <td><?php echo $property['HOA_Pay_Schedule']; ?></td>
                      </tr>
                      <tr>
  							        <td>Condo Fee Includes</td>
                        <td><?php echo $property['HOA_Includes']; ?></td>
                      </tr>
                      <?php endif; ?>

  							      <?php if (isset($property['Bedrooms_Above_Grade'])): ?>
                      <tr>
  							        <td>Bedrooms Above Grade</td>
                        <td><?php echo $property['Bedrooms_Above_Grade']; ?></td>
                      </tr>
                      <?php endif; ?>
                      
  							      <?php if (isset($property['Number_of_Half_Baths'])): ?>
                      <tr>
  							        <td>Half Baths</td>
                        <td><?php echo $property['Number_of_Half_Baths']; ?></td>
                      </tr>
                      <?php endif; ?>
                      
  							      <?php if (isset($property['Parking'])): ?>
                      <tr>
  							        <td>Parking</td>
                        <td><?php echo $property['Parking']; ?></td>
                      </tr>
                      <?php endif; ?>
                                            
  							      <?php if (intval($property['HasFirePlace']) === 1): ?>
                      <tr>
  							        <td>Fireplace</td>
                        <td><?php echo $property['Fireplace']; ?></td>
                      </tr>
                      <tr>
  							        <td>Fireplace Fuel</td>
                        <td><?php echo $property['Fireplace_Fuel']; ?></td>
                      </tr>
                      <?php endif; ?>
                                                                  
  							      <?php if (isset($property['Construction_Type'])): ?>
                      <tr>
  							        <td>Construction Type</td>
                        <td><?php echo $property['Construction_Type']; ?></td>
                      </tr>
                      <?php endif; ?>

  							      <?php if (isset($property['Foundation'])): ?>
                      <tr>
  							        <td>Foundation</td>
                        <td><?php echo $property['Foundation']; ?></td>
                      </tr>
                      <?php endif; ?>
                                            
  							      <?php if (isset($property['Depth_In_Feet'])): ?>
                      <tr>
  							        <td>Depth</td>
                        <td><?php echo $property['Depth_In_Feet']; ?> ft</td>
                      </tr>
                      <?php endif; ?>
                      
  							      <?php if (isset($property['Frontage_In_Feet'])): ?>
                      <tr>
  							        <td>Frontage</td>
                        <td><?php echo $property['Frontage_In_Feet']; ?> ft</td>
                      </tr>
                      <?php endif; ?>
                      
  							      <?php if (isset($property['HeatingFuel'])): ?>
                      <tr>
  							        <td>Heating Fuel</td>
                        <td><?php echo $property['HeatingFuel']; ?></td>
                      </tr>
                      <?php endif; ?>
                                       
  							      <?php if (isset($property['Basement'])): ?>
                      <tr>
  							        <td>Basement</td>
                        <td><?php echo $property['Basement']; ?></td>
                      </tr>
                      <?php endif; ?>
                      
  							      <?php if (isset($property['Basement_Develop'])): ?>
                      <tr>
  							        <td>Basement Type</td>
                        <td><?php echo $property['Basement_Develop']; ?></td>
                      </tr>
                      <?php endif; ?>
                      
  							      <?php if (isset($property['Sewer'])): ?>
                      <tr>
  							        <td>Sewer</td>
                        <td><?php echo $property['Sewer']; ?></td>
                      </tr>
                      <?php endif; ?>
                      
  							      <?php if (isset($property['Water'])): ?>
                      <tr>
  							        <td>Water</td>
                        <td><?php echo $property['Water']; ?></td>
                      </tr>
                      <?php endif; ?>
                      
							      </table>
							    </div>
							  </div>

							  <div class="property-feature">
							    <h4 class="property-feature-title">Rooms</h4>
							    <div class="property-feature-content clearfix">
							      <table class="table table-striped table-condensed rooms">
                      <tr>
                        <th>Level</th>
                        <th>Type</th>
                        <th>Dimensions</th>
                      </tr>                      
                      <?php foreach ($room_data as $room): ?>
  							      <tr>
  							        <td><?php echo $room['Level']; ?></td>

                        <td><?php echo $room['Type']; ?></td>
                        <td><?php echo $room['Dimension1']; ?> x <?php echo $room['Dimension2']; ?></td>
                      </tr>
  							      <?php endforeach; ?>
							      </table>
							    </div>
							  </div>
							  
							  <div class="property-map">
							    <h4 class="property-map-title">Find this property on map</h4>
							    <div class="property-map-content">
										<div class="property-map-box">
                      <iframe
                        height="230"
                        frameborder="0" style="border:0"
                        src="https://www.google.com/maps/embed/v1/place?q=<?php echo $property['Street_Number']; ?>+<?php echo $property['Street_Name']; ?>+<?php echo $property['Street_Type']; ?>,+<?php echo $property['City_or_Town_Name']; ?>, Manitoba Canada&key=AIzaSyB0-zo6l2gAtUQ4UjGQBH3OH42T8f8nXow">
                      </iframe>
                    </div>
									</div>
							  </div>
							</article>
				  		<!-- END ARTICLE PROPERTY -->

							<!-- START AGENT PROPERTY -->
							<div class="agent-property">
							  <div class="agent-property-title">
							    <h3>Contact Agent</h3>
							  </div>
							  <div class="agents grid clearfix">
							    <article class="hentry">
							      <div class="agent-featured">
							          <img src="<?php echo $assets_path; ?>images/agent/Blair.jpg" class="attachment-agent-thumb" alt="Blair Sonnichsen">
							      </div>
							      <div class="agent-wrap">
							        <div class="agent-summary">
							          <div class="agent-info">
							            <div><strong>Blair Sonnichsen</strong></div>
							            <div>Royal LePage Dynamic</div>
							            <div><i class="fa fa-phone"></i>&nbsp;204-989-5000</div>
							            <div><i class="fa fa-envelope-square"></i>&nbsp;<a href="mailto:Blair@WinnipegHomes.com">Blair@WinnipegHomes.com</a></div>
							          </div>
							          <div class="agent-desc">
							          	<ul class="social-list agent-social clearfix">
												    <li><a href="https://www.facebook.com/WinnipegHomesCom" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
												    <li><a href="https://plus.google.com/102215000599552351305/posts" title="Google +" target="_blank"><i class="fa fa-google-plus"></i></a></li>
												  </ul>
							            <div class="agent-action">
							              <a href="mailto:Blair@WinnipegHomes.com">Email Blair</a>
							            </div>
							          </div>

							        </div>
							      </div>
							    </article>
							    <div class="contact-agent">
							      <form role="form" id="conactagentform" method="post">
							        <div class="form-group">
							          <input type="text" name="name" class="form-control" placeholder="Your Name *">
							        </div>
							        <div class="form-group">
							          <input type="email" name="email" class="form-control" placeholder="Your Email *">
							        </div>
							        <div class="form-group">
							          <textarea name="message" class="form-control" placeholder="Message *"></textarea>
							        </div>
							        <div class="form-action">
							          <button type="submit" class="btn btn-default send-message" data-email="Blair@WinnipegHomes.com">Send a Message</button>
							        </div>
							      </form>
							    </div>
							  </div>
							  
							  <div class="agents grid clearfix">
							    <article class="hentry">
							      <div class="agent-featured">
							          <img src="<?php echo $assets_path; ?>images/agent/Tyson.jpg" class="attachment-agent-thumb" alt="Tyson Sonnichsen">
							      </div>
							      <div class="agent-wrap">
							        <div class="agent-summary">
							          <div class="agent-info">
							            <div><strong>Tyson Sonnichsen</strong></div>
							            <div>Royal LePage Dynamic</div>
							            <div><i class="fa fa-phone"></i>&nbsp;204-989-5000</div>
							            <div><i class="fa fa-envelope-square"></i>&nbsp;<a href="mailto:Tyson@WinnipegHomes.com">Tyson@WinnipegHomes.com</a></div>
							          </div>
							          <div class="agent-desc">
							          	<ul class="social-list agent-social clearfix">
												    <li><a href="https://www.facebook.com/WinnipegHomesCom" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
												    <li><a href="https://plus.google.com/102215000599552351305/posts" title="Google +" target="_blank"><i class="fa fa-google-plus"></i></a></li>
												  </ul>
							            <div class="agent-action">
							              <a href="mailto:Tyson@WinnipegHomes.com"">Email Tyson</a>
							            </div>
							          </div>

							        </div>
							      </div>
							    </article>
							    <div class="contact-agent">
							      <form role="form" id="conactagentform" method="post">
							        <div class="form-group">
							          <input type="text" name="name" class="form-control" placeholder="Your Name *">
							        </div>
							        <div class="form-group">
							          <input type="email" name="email" class="form-control" placeholder="Your Email *">
							        </div>
							        <div class="form-group">
							          <textarea name="message" class="form-control" placeholder="Message *"></textarea>
							        </div>
							        <div class="form-action">
							          <button type="submit" class="btn btn-default send-message" data-email="Tyson@WinnipegHomes.com">Send a Message</button>
							        </div>
							      </form>
							    </div>
							  </div>
							</div>

						</div>	  		
				  	<!-- END MAIN CONTENT -->
				  	
				  	<!-- START SIDEBAR -->
	          <div class="noo-sidebar noo-sidebar-right col-xs-12 col-md-4">
	            <div class="noo-sidebar-inner">
	              <!-- START FIND PROPERTY -->
	              <div class="block-sidebar find-property">
	                <h3 class="title-block-sidebar">Find Property</h3>
	                <div class="gsearch">
	                  <div class="gsearch-wrap">
	                    <form class="gsearchform" method="get" role="search">
	                      <div class="gsearch-content">
	                        <div class="gsearch-field">
	                          <div class="form-group gtype">
	                            <div class="label-select">
	                              <select class="form-control" id="search-type">
	                                <option value="all">All Types</option>
	                                <option value="res">Residential</option>
	                                <option value="con">Condo</option>
	                                <option value="rur">Rural</option>
	                              </select>
	                            </div>
	                          </div>

	                          <div class="form-group gbed">
	                            <div class="label-select">
	                              <select class="form-control" id="search-bedrooms">
	                                <option value="1">No. of Bedrooms</option>
	                                <option value="1">1</option>
	                                <option value="2">2</option>
	                                <option value="3">3</option>
	                                <option value="4">4</option>
	                                <option value="5">5+</option>
	                              </select>
	                            </div>
	                          </div>

	                          <div class="form-group gbath">
	                            <div class="label-select">
	                              <select class="form-control" id="search-bathrooms">
	                                <option value="1">No. of Bathrooms</option>
	                                <option value="1">1</option>
	                                <option value="2">2</option>
	                                <option value="3">3</option>
	                                <option value="4">4+</option>
	                              </select>
	                            </div>
	                          </div>

	                          <div class="form-group gprice" id="search-price">
	                            <span class="gprice-label">Price</span>
	                            <div class="gslider-range gprice-slider-range"></div>
	                            <span class="gslider-range-value gprice-slider-range-value-min"></span>
	                            <span class="gslider-range-value gprice-slider-range-value-max"></span>
	                          </div>

	                        </div>

	                        <div class="gsearch-action">
	                          <div class="gsubmit">
	                            <a class="btn btn-deault" href="#" id="search-button">Search Property</a>
	                          </div>
	                        </div>
	                      </div>
	                    </form>
	                  </div>
	                </div>
	              </div>
	              <!-- END FIND PROPERTY -->

	              <!-- START CALCULATOR -->
	              <div class="block-sidebar">
	                <h3 class="title-block-sidebar">Mortgage Calculator</h3>
	                <div class="calculator">
	                  <div class="calculator-wrap">
	                    <form id="calculator">
                        <div class="form-group">
                          <label for="property_value">Property Value:</label>
                          <input type="text" id="property_value" value="<?php echo $property['CurrentPrice']; ?>" />                       
                        </div>
                        
                        <div class="form-group">
                          <label for="down_payment_amount">Down Payment ($):</label>
                          <input type="text" id="down_payment_amount" />
                        </div>

                        <div class="form-group">
                          <label for="down_payment_percentage">Down Payment (%):</label>
                          <input type="text" id="down_payment_percentage" value="5" />
                        </div>
                        
                        <div class="form-group">
                          <label for="mortgage">Mortgage Amount:</label>
                          <input type="text" id="mortgage" readonly />
                        </div>
                        
                        <div class="form-group">
                          <label for="interest_rate">Interest Rate (%)</label>
                          <input type="text" id="interest_rate" value="5.00" />
                        </div>
                        
                        <div class="form-group">
                          <label for="years">Number of Years:</label>
                          <input type="text" id="years" value="25" />
                        </div>
                        
                        <hr />
                        
                        <div class="form-group">
                          <label for="payment">Monthly Payment</label>
                          <input type="text" id="payment" readonly />
                        </div>

	                    </form>
	                  </div>
	                </div>
	              </div>
	              <!-- END CALCULATOR -->
	              
	            </div>
	          </div>
	          <!-- END SIDEBAR -->
          </div>
        </div>
      </div>
      <!-- END NOO MAINBODY -->
    </div>
    <!-- END NOO WRAPPER -->