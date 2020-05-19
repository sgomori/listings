

    <!-- START NOO WRAPPER -->
    <div class="noo-wrapper">

      <!-- START NOO MAINBODY -->
      <div class="container noo-mainbody">
        <div class="noo-mainbody-inner">
          <div class="row clearfix">
 				  	<!-- START MAIN CONTENT -->
				  	<div class="noo-content col-xs-12 col-md-8">
				  		<!-- START ARTICLE PROPERTY -->
							<article class="property" itemscope itemtype="http://schema.org/RealEstateListing">
							  <h1 class="properties-header" itemprop="name">
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
							    <small><?php echo $property['Neighbourhood']; ?>, <?php echo $city_prov; ?> <?php echo $postal_code; ?></small>
							  </h1>
							  
							  <?php if (!empty($property_images)): ?>
							  
                <div id="gallery" class="flexslider">
                  <ul class="slides">
                    <?php foreach ($property_images as $property_image): ?>
                		<li>
                	    <?php if (($property['Status'] === 'Sold') && ($property['Sold_Date'] !== '0000-00-00 00:00:00') && (strtotime($property['Sold_Date']) < time())): ?>
                      <span class="property-label">Sold</span>
                      <?php elseif ($property['Status'] === 'Pending'): ?>
                      <span class="property-label">Sale Pending</span>                    
                      <?php elseif ((isset($property['Open_House_Date_NUM1'])) && ((strtotime($property['Open_House_Date_NUM1']) + (3600 * 24)) > time())): ?>
                      <span class="property-label">Open House - <?php echo date('l', strtotime($property['Open_House_Date_NUM1'])); ?></span>                        
                      <?php elseif ((strtotime($property['LastChangeTypeDate']) > (time() - (3600 * 24 * 14))) && ($property['LastChangeType']) && ($property['LastChangeType'] !== '') && (!in_array(strtolower($property['LastChangeType']), array('price change', 'back on market', 'pending')))): ?>
                      <span class="property-label"><?php echo $property['LastChangeType']; ?></span>
                      <?php endif; ?>
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
							  
								<div class="mobile-only">
                  <a href="#calculator-anchor">Mortgage Calculator</a>
                </div>

							  <div class="property-summary">
							    <div class="row">
							      <div class="col-md-4">
							        <div class="property-detail">
							          <h2 class="property-highlights-title">Property Detail</h2>
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
							          <h2 class="property-detail-title open-house">Open House</h2>
							          
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
                                                
							          <h2 class="property-detail-title">Property Description</h2>
							          <p itemprop="description"><?php echo $property['Public_Remarks']; ?></p>

							          <?php if ((isset($property['Virtual_Tour_Link'])) && ($property['Virtual_Tour_Link'] !== '')): ?>
							          <p><a href="<?php echo $property['Virtual_Tour_Link']; ?>" target="_blank">View the virtual tour</a></p>
							          <?php endif; ?>
                        
                        <p class="meta">
                          <span class="listed-by">Listing Agent: <span itemscope itemtype="http://schema.org/RealEstateAgent"><span itemprop="name"><?php echo $property['Agent_1_First_Name']; ?> <?php echo $property['Agent_1_Last_Name']; ?></span></span>
                          <?php if (isset($property['Agent_2_First_Name']) && ($property['Agent_1_First_Name'] !== '')): ?>
                            and <span itemscope itemtype="http://schema.org/RealEstateAgent"><span itemprop="name"><?php echo $property['Agent_2_First_Name']; ?> <?php echo $property['Agent_2_Last_Name']; ?></span></span>
                          <?php endif; ?>
                          </span>
                          
                          <br />                                                    
                          <span>Listing Date: <span itemprop="datePosted"><?php echo $listing_date; ?></span></span>
                          
                          <?php if ($updated_date): ?>
                          <br />
                          <span>Updated: <span itemprop="dateModified"><?php echo $updated_date; ?></span></span>
                          <?php endif; ?>
                        </p>                 
							        </div>
							      </div>
							    </div>
							  </div>

							  <?php if ($features): ?>
                <div class="property-feature">
							    <h2 class="property-feature-title">Property Features</h2>
							    <div class="property-feature-content clearfix">
							      <?php foreach ($features as $feature): ?>
							      <div class="has">
							        <i class="fa fa-check-circle"></i> <?php echo $feature; ?>
                    </div>
							      <?php endforeach; ?>
							    </div>
							  </div>
                <?php endif; ?>                
							  
							  <?php if ($amenities): ?>
							  <div class="property-feature">
							    <h2 class="property-feature-title">Amenities</h2>
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
							    <h2 class="property-feature-title">Site Influences</h2>
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
							    <h2 class="property-feature-title">Flooring</h2>
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
							    <h2 class="property-feature-title">More Details</h2>
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

							  <?php if ($room_data): ?>
                <div class="property-feature">
							    <h2 class="property-feature-title">Rooms</h2>
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
                <?php endif; ?>                                                

							  <div class="property-map">
							    <h2 class="property-map-title">Find this property on map</h2>
							    <div class="property-map-content">
										<div id="google-property-map" class="property-map-box">
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
							          <button type="submit" class="btn btn-default send-message" data-email="Blair@WinnipegHomes.com" data-cc="Tyson@WinnipegHomes.com">Send a Message</button>
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
												  </ul>
							            <div class="agent-action">
							              <a href="mailto:Tyson@WinnipegHomes.com">Email Tyson</a>
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
							          <button type="submit" class="btn btn-default send-message" data-email="Tyson@WinnipegHomes.com" data-cc="Blair@WinnipegHomes.com">Send a Message</button>
							        </div>
							      </form>
							    </div>
							  </div>
                
							  <div class="agents grid clearfix">
							    <article class="hentry">
							      <div class="agent-featured">
							          <img src="<?php echo $assets_path; ?>images/agent/Nancy.jpg" class="attachment-agent-thumb" alt="Nancy Dilts">
							      </div>
							      <div class="agent-wrap">
							        <div class="agent-summary">
							          <div class="agent-info">
							            <div><strong>Nancy Dilts</strong></div>
							            <div>Royal LePage Dynamic</div>
							            <div><i class="fa fa-phone"></i>&nbsp;204-989-5000</div>
							            <div><i class="fa fa-envelope-square"></i>&nbsp;<a href="mailto:Nancy@WinnipegHomes.com">Nancy@WinnipegHomes.com</a></div>
							          </div>
							          <div class="agent-desc">
							          	<ul class="social-list agent-social clearfix">
												    <li><a href="https://www.facebook.com/WinnipegHomesCom" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
												  </ul>
							            <div class="agent-action">
							              <a href="mailto:Nancy@WinnipegHomes.com">Email Nancy</a>
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
							          <button type="submit" class="btn btn-default send-message" data-email="Nancy@WinnipegHomes.com" data-cc="Blair@WinnipegHomes.com">Send a Message</button>
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
	                <h4 class="title-block-sidebar">Find Property</h4>
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
	                <h4 class="title-block-sidebar" id="calculator-anchor">Mortgage Calculator</h4>
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
                
                <?php if (!empty($similar_listings)): ?>
	              <!-- START SIMILAR -->
	              <div class="block-sidebar">
	                <h4 class="title-block-sidebar" id="calculator-anchor">Similar Listings</h4>


                  <?php foreach ($similar_listings as $listing) : ?>
	                <div class="similar-listing">                  
                    <article class="hentry">
                      <div class="property-featured">
                        <?php if (file_exists(FCPATH.'assets/images/properties/image-'.$listing['Matrix_Unique_ID'].'-0.jpg')): ?>
                        <?php echo anchor($types[$listing['class']]['path'].'/'.$listing['Matrix_Unique_ID'].'/'.$listing['address_slug'], '<img src="'.$assets_path.'images/properties/image-'.$listing['Matrix_Unique_ID'].'-0.jpg" alt="">', array('class' => 'content-thumb')); ?>
                        <?php else: ?>
                        <?php echo anchor($types[$listing['class']]['path'].'/'.$listing['Matrix_Unique_ID'].'/'.$listing['address_slug'], '<img src="'.$assets_path.'images/properties/default.gif" alt="">', array('class' => 'content-thumb')); ?>
                        <?php endif; ?>
                       <div class="property-price">$ <?php echo number_format($listing['CurrentPrice'], 0); ?></div>                            
                      </div>
                      <div class="property-wrap">
                        <h5 class="property-title">
                          <?php if (intval($listing['Display_Addrs_on_Pub_Web_Sites']) === 1): ?>
                            <?php
                              $address = $listing['Street_Number'].' '.ucwords(strtolower($listing['Street_Name'])).' '.ucfirst(strtolower($listing['Street_Type'])).' - '.$listing['Neighbourhood'].', '.ucwords(strtolower($listing['City_or_Town_Name']));
                              
                              if ($listing['Suite_Number'] !== '')
                              {
                                $address = $listing['Suite_Number'].' - '.$address;
                              }
                            ?>
                          <?php echo anchor($types[$listing['class']]['path'].'/'.$listing['Matrix_Unique_ID'].'/'.$listing['address_slug'], $address, array('class' => $listing['class'])); ?>
                          <?php endif; ?>
                        </h5>

                        <div class="property-summary">
                          <div class="property-detail">
                            <div class="size">
                              <span><?php echo $listing['Total_FloorLiv_Area_SF']; ?> sqft</span>
                            </div>
                            <div class="bedrooms">
                              <span><?php echo $listing['Total_Bedrooms']; ?> bedroom<?php if ((int)$listing['Total_Bedrooms'] > 1): ?>s<?php endif; ?></span>
                            </div>
                            <div class="bathrooms">
                              <span><?php echo $listing['Number_of_Total_Baths']; ?> bathroom<?php if ((int)$listing['Number_of_Total_Baths'] > 1): ?>s<?php endif; ?></span>
                            </div>
                            <div class="property-action">
                              <?php echo anchor($types[$listing['class']]['path'].'/'.$listing['Matrix_Unique_ID'].'/'.$listing['address_slug'], 'More Details'); ?>
                            </div>
                          </div>

                        </div>
                      </div>

                    </article>
	                </div>                        
                  <?php endforeach; ?>
  

	              </div>
	              <!-- END SIMILAR -->
                <?php endif; ?>
                	              
	            </div>
	          </div>
	          <!-- END SIDEBAR -->
          </div>
        </div>
      </div>
      <!-- END NOO MAINBODY -->
    </div>
    <!-- END NOO WRAPPER -->