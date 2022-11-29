<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$my_listing_ID = get_the_ID(  );
$user_id = $profile->user_info->ID;
$loader = $contitional_input = $menu_listing_id = '';
$current_user = get_current_user_id();
$author_id = get_post_field( 'post_author', $my_listing_ID );
?>
<div class="container-fluid">
    <?php get_template_part('template-parts/profile/author-stats/stats'); ?>
    <div class="row">
        <?php
         $paged = 1;
            $query_args = array(
                'post_type' => 'reservation',
                'posts_per_page'=>10,
                'paged' =>  $paged,
                'meta_query' => array(
                    array(
                        'key' => 'dwt_listing_author',
                        'compare' => '=',
                        'value'=> get_current_user_id(),
                    ),
                ),
            );
            $loop = new WP_Query( $query_args );    
        ?>
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Recieved Appointments', 'dwt-listing');?></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive dwt-admin-tabelz">
                        <div class="recieved-booking">
                            <table class="dwt-admin-tabelz-panel table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo esc_html__('Client Name', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Number', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Email', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Date', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Timings', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Lisitng Id', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Lisitng Name', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Lisitng Status', 'dwt-listing'); ?></th>
                                    </tr>
                                </thead>
                                <?php
                                while ( $loop->have_posts() ) : $loop->the_post(); 
                                    $theid = get_the_ID(  );
                                $listing_title = get_the_title( );
                                $reservation_name = get_post_meta( $theid, 'dwt_listing_reserver_name', true );
                                $reservation_number = get_post_meta( $theid, 'dwt_listing_reserver_number', true );
                                $reservation_email = get_post_meta( $theid, 'dwt_listing_reserver_email', true );
                                $reservation_day = get_post_meta( $theid, 'dwt_listing_reservation_day', true );
                                $reservation_time = get_post_meta( $theid, 'dwt_listing_reservation_time', true );
                                $reservation_id = get_post_meta( $theid, 'dwt_listing_reservation_id', true );
                                $reservation_listing_title = get_post_meta( $theid, 'dwt_listing_reservation_title', true );

                                /*---------addding table for recieved booking--------------*/
                                ?>
                                <tbody>
                                    <tr class="unique-key->">
                                        <td><?php echo $reservation_name;    ?></td>    
                                        <td><?php echo $reservation_number;  ?></td>
                                        <td><?php echo $reservation_email;   ?></td>
                                        <td><?php echo $reservation_day;     ?></td>
                                        <td><?php echo $reservation_time;    ?></td> 
                                        <td><?php echo $reservation_id;      ?></td>
                                        <td><?php echo $reservation_listing_title;  ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <!-- modale for email -->                             
                                                <div class="modal fade booking_status_email" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel"><?php echo esc_html__('New message', 'dwt-listing');?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="form_booking_email" id="form_booking_email">
                                                                    <div class="form-group">
                                                                        <label for="message-text" class="col-form-label"><?php echo esc_html__('Message:', 'dwt-listing');?></label>
                                                                        <textarea class="form-control" id="message-text" rows= "12" required></textarea>
                                                                        <input type="hidden" id="current_booking_id">
                                                                        <input type="hidden" id="current_booking_status">
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary" id="send_email"><?php echo esc_html__('Send message', 'dwt-listing');?></button>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo esc_html__('Close', 'dwt-listing');?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                            <!-- Modale for Email -->
                                                    <label for="cars"><?php //echo esc_html__('Status', 'dwt-listing');?></label>
                                                        <?php   
                                                            $current_status = get_post_meta( $theid , 'booked_listings_reservations', true );
                                                            $current_status  =  $current_status == ""   ?  esc_html__('Pending','dwt-listing') : $current_status;
                                                        ?>
                                                    <select name="reserving_status" data-id="<?php echo $theid; ?>" class="booking_status" id="booking_status">
                                                        <option value="Pending" <?php  if($current_status == 'Pending' ) {echo 'selected';} ?>><?php echo esc_html__('Pending', 'dwt-listing');?></option>
                                                        <option value="Approved" <?php if($current_status == 'Approved' ) {echo 'selected';} ?>><?php echo esc_html__('Approved', 'dwt-listing');?></option>
                                                        <option value="rejected" <?php if($current_status == 'rejected' ) {echo 'selected';} ?>><?php echo esc_html__('rejected', 'dwt-listing');?></option>
                                                    </select>
                                            </div>
                                        </td>     

                                    </tr>
                                        <?php
                                    wp_reset_postdata();
                                    ?>
                                </tbody>
                                <?php    endwhile;
                                ?>
                            </table>
                        </div>
                    </div>
                    <div class="admin-pagination">
                            <?php echo dwt_listing_listing_pagination($loop); ?>
                        </div>
                </div>
                
            </div>
                <?php
            wp_reset_postdata();?>
           
            <?php $paged = 1;
            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

                the_excerpt(); 
            wp_reset_postdata(); 
            ?>
        </div>
    </div>
</div>