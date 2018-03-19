<?php





get_template_part( 'template-parts/main-content', 'header' );
?>

    <div class="ct main-content---ct">
        <div class="mn main-content---mn" data-main-name="Main Content MAIN">

            <?php

            while ( have_posts() ) {

                the_post();

                // Page Content
                ob_start();
                applicator_entry_content();            
                $entry_content = ob_get_clean();
            }
            
            
            // Category Posts Content
            ob_start();
            
            
            // Paged
            if ( get_query_var( 'paged' ) )
            {
                $paged = get_query_var( 'paged' );
            }
            elseif ( get_query_var( 'page' ) )
            {
                $paged = get_query_var( 'page' );
            }
            else
            {
                $paged = 1;
            }
            
            
            // Override via Custom Fields
            $category_name_post_meta = get_post_meta( get_the_ID(), 'Applicator: Category Name', true );
    
            if ( $category_name_post_meta )
            {
                $category_name = wp_strip_all_tags( $category_name_post_meta );
            }
            
            // Or the Post's slug
            else
            {
                $category_name = $post->post_name;
            }
            
            
            // Query Arguments
            $args = array(
                'posts_per_page'        => get_option( 'posts_per_page' ),
                'ignore_sticky_posts'   => true,
                'category_name'         => $category_name,
                'paged'                 => $paged,
            );            
            
            
            $the_query = new WP_Query( $args );

            if ( $the_query->have_posts() )
            {
                
                while ( $the_query->have_posts() )
                {   
                    $the_query->the_post();
                    applicator_entry_content();
                    
                    $big = 999999999; 
                    echo paginate_links( array(
                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, get_query_var( 'paged' ) ),
                        'total' => $the_query->max_num_pages,
                        
                        'show_all'              => true,
                        'mid_size'              => 0,

                        'type'                  => 'list',

                        'before_page_number'    => '',
                        'after_page_number'     => '',

                        'prev_text'             => 'Previous',
                        'next_text'             => 'Next',
                    ) );
                }
            }
            wp_reset_postdata();

            $projects_content_ob = ob_get_clean();


            $projects_cp = applicator_htmlok( array(
                'name'      => 'Projects Content',
                'structure' => array(
                    'type'      => 'component',
                    'elem'      => 'section',
                    'h_elem'    => 'h2',
                ),
                'content'   => array(
                    'component'     => array(
                        $projects_content_ob,
                    ),
                ),
            ) );


            $entry_entries_cp = applicator_htmlok( array(
                'name'      => 'Entry',
                'structure' => array(
                    'type'      => 'component',
                ),
                'content'   => array(
                    'component'     => array(
                        $entry_content,
                    ),
                ),
            ) );


            $entry_module_cp = applicator_htmlok( array(
                'name'      => 'Entry',
                'structure' => array(
                    'type'      => 'component',
                    'subtype'   => 'module',
                ),
                'content'   => array(
                    'component'     => array(
                        $entry_entries_cp,
                    ),
                ),
            ) );


            $primary_content = applicator_htmlok( array(
                'name'      => 'Primary Content',
                'structure' => array(
                    'type'      => 'constructor',
                    'elem'      => 'main',
                ),
                'id'        => 'main',
                'css'       => 'pri-content',
                'root_css'  => 'site-main',
                'content'   => array(
                    'constructor'   => array(
                        $entry_module_cp,
                        $projects_cp,
                    ),
                ),
                'echo'      => true,
            ) );


            get_sidebar();

            ?>

        </div>
    </div>

<?php

get_template_part( 'template-parts/main-content', 'footer' );