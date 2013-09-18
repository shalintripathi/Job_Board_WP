<table width="100%" cellspacing="0">
	<tbody>
	<?php if (have_posts()):?>
<?php
//get current time
?>
			 <?php while (have_posts()):?>  
			 <?php the_post();?>
			 <?php 
			 	global $post, $user_ID;
				$company = &get_post_meta($post->ID, 'tgt_job_content', true);
				$color = &get_post_meta($post->ID,'tgt_job_effect_color',true);
				$status = get_metadata('user', $user_ID,'tgt_jobseeker_store',true);
				
				$font = &get_post_meta($post->ID,'tgt_job_effect_font',true);
				$bg = get_post_meta($post->ID,'tgt_job_type_bg',true);
				$jobtype_color = get_option('tgt_jobtype_color');
				$jobtype = &get_post_meta($post->ID,'tgt_job_type',true);
				$country = &get_post_meta($post->ID,'tgt_job_country',true);										
				$state = &get_post_meta($post->ID,'tgt_job_state',true);
				$city = &get_post_meta($post->ID,'tgt_job_city',true);
				$time_renew = &get_post_meta($post->ID, 'tgt_job_renew', true);
				//$day_ago = floor((time() - strtotime($post->post_date)) / 86400);
				$posttime = $post->post_date;
				$posttime = explode(" ", $posttime);		
				$inposttime = $posttime[0];
				$inposttime = explode("-", $inposttime);
				
				$a  = mktime(0, 0, 0, $inposttime[1],   $inposttime[2],   $inposttime[0]);				
				$typeclass = tgt_get_jobtype_style($jobtype);;
				
				$location_filter = array();
				if ( !empty($city) )
					$location_filter[] = '<a href="' . htmlspecialchars( get_bloginfo('url') . '?s=jobseeker&usertype=jobseeker&city=' . str_replace(' ','+',$city) ) . '">' . $city . '</a>' ;
				if ( !empty($state) )
					$location_filter[] = '<a href="' . htmlspecialchars( get_bloginfo('url') . '?s=jobseeker&usertype=jobseeker&state=' . str_replace(' ','+',$state) ) . '">' . $state . '</a>' ;
				if ( !empty($country) )
					$location_filter[] = '<a href="' . htmlspecialchars( get_bloginfo('url') . '?s=jobseeker&usertype=jobseeker&country=' . str_replace(' ','+',$country) ) . '">' . $country . '</a>' ;
				?>           
		<tr>
			<td class="col-symbol">
				<?php                                            
				if(isset($status['j_'.$post->ID]) && $status['j_'.$post->ID] === 'Noted')
				{
				?>
					<img title="Saved This Job" src="<?php echo TEMPLATE_URL?>/images/star_hover.png" alt=""/>
				<?php
				}else if(isset($status['j_'.$post->ID]) && $status['j_'.$post->ID] === 'Applied')
				{
				?>
					<img title="Applied This Job" src="<?php echo TEMPLATE_URL?>/images/select.png" alt=""/>
				<?php
				}
				else
				{
				?>
					<img src="<?php// echo TEMPLATE_URL?>/images/star.png" alt=""/>
				<?php } ?>
			</td>
			<td class="col-imgage">
				<img class="job-thumb" src="<?php //echo get_company_logo($post->ID ); ?>" alt="logo" />
			</td>
			<td class="col-content">
				<p class="joblist-content">
					<a class="job-title" href='<?php the_permalink();?>' style="font-weight:<?php echo $font?>;font-style:<?php echo $font; ?>;" >
						<font color="#<?php// echo (isset($color['code']))?$color['code']:''?>">
							<?php echo $post->post_title; ?>
						</font>
				   </a>
					<?php
					$count_view_job = get_post_meta($post->ID, 'tgt_count_view_job', true);
					if($count_view_job < 1 || $count_view_job == null)
						 $count_view_job = 0;
					if($count_view_job > 1) $view = __('views','jobpress');
					else $view = __('view','jobpress');			
					?>
					<span class="job-type <?php echo tgt_get_jobtype_style( get_post_meta($post->ID,'tgt_job_type',true) )?>">
						<?php echo get_post_meta($post->ID,'tgt_job_type',true); ?>
					</span>
				</p>
				
            <p>
				<span><?php _e('at','jobpress');?>&nbsp;&nbsp;<a href="<?php echo tgt_view_profile_company($post->post_author);?>" target="_blank"><?php if(isset($company['company'])) echo $company['company'];?></a>&nbsp;&nbsp;<?php _e('in','jobpress'); ?>&nbsp;&nbsp;
					<?php 
					echo implode( ', ' , $location_filter );
					?> 
				</span>
				</p>
			</td>
			<td class="col-job-date">
				<p class="clock" style="text-align:right;">               
					<img style="margin-right:10px;" src="<?php echo TEMPLATE_URL?>/images/icon_clock.png" alt=""/>
					<?php echo tgt_check_time_left($post->post_date)  ;?>
				</p>
			</td>
		</tr>                                       
	<?php endwhile;?>
	<?php endif;?>
	</tbody>
</table>
