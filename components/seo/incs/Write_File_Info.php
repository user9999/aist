<?php
error_reporting ( 0 );
include_once 'Toolkit_Version.php';
include_once 'JPEG.php';
include_once 'XMP.php';
include_once 'Photoshop_IRB.php';
include_once 'EXIF.php';
include_once 'Photoshop_File_Info.php';

                        foreach( $new_ps_file_info_array as $var_key => $var_val )
                        {
                                $new_ps_file_info_array[ $var_key ] = stripslashes( $var_val );
                        }


                        $new_ps_file_info_array[ 'keywords' ] = explode( ",", trim( $new_ps_file_info_array[ 'keywords' ] ) );


                        $new_ps_file_info_array[ 'supplementalcategories' ] = explode( ",", trim( $new_ps_file_info_array[ 'supplementalcategories' ] ) );


                        $filename = $new_ps_file_info_array[ 'filename' ];
			$outputfilename = $new_ps_file_info_array[ 'outputfilename' ];
			copy($filename, $outputfilename);

                        $path_parts = pathinfo( $filename );
                        if ( strcasecmp( $path_parts["extension"], "jpg" ) != 0 )
                        {
				$e="Error - Wrong file";
                                return $e;
                                exit( );
                        }
                        $jpeg_header_data = get_jpeg_header_data( $filename );

                        $Exif_array = get_EXIF_JPEG( $filename );
                        $XMP_array = read_XMP_array_from_text( get_XMP_text( $jpeg_header_data ) );
                        $IRB_array = get_Photoshop_IRB( $jpeg_header_data );

                        $jpeg_header_data = put_photoshop_file_info( $jpeg_header_data, $new_ps_file_info_array, $Exif_array, $XMP_array, $IRB_array );

                        if ( $jpeg_header_data == FALSE )
                        {
				$e="Error - Failure update Photoshop File Info";
                                return $e;
                                $outputfilename = $new_ps_file_info_array[ 'outputfilename' ];
                                exit( );
                        }

                        if ( FALSE == put_jpeg_header_data(  $filename, $outputfilename,  $jpeg_header_data ) )
                        {
				$e="Error - Failure update Photoshop File Info";
                                return $e;
                                $outputfilename = $new_ps_file_info_array[ 'outputfilename' ];
                                exit( );
                        }
?>
