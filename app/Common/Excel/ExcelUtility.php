<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 16/05/2018
 * Time: 16:35 PM
 */

namespace App\Common\Excel;
 

class ExcelUtility
{
    
    const style_title = array(
        'font'  => array(
            'bold'  => true, 
            'size'  => 15,
            // 'name'  => 'Arial'                
        ),
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
    );
    const style_search = array(
        'font'  => array( 
            //'name'  => 'Arial'   ,
            //'italic' =>true
        ),
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
    );
    const style_grid_title = array(
        'font'  => array(
            'bold'  => true,  
            //'name'  => 'Arial'                
        ),
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
    );
    const style_grid_title_left = array(
        'font'  => array(
            'bold'  => true,  
          //  'name'  => 'Arial'                
        ),
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
    );
    
    const style_grid_title_right = array(
        'font'  => array(
            'bold'  => true,  
          //  'name'  => 'Arial'                
        ),
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
    );
    
    const style_grid_content = array(
        'font'  => array(
          //  'name'  => 'Arial'                
        ),
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
    );
    
    const style_grid_content_left = array(
        'font'  => array(           
            //'name'  => 'Arial'                
        ),
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_LEFT,
        ),
    );
    const style_title_custom = array(
        'font'  => array(
            'bold'  => true,
            'size'  => 12,
            'name'  => 'Arial'
        ),
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
    );

    const style_grid_title_center_custom = array(
        'font'  => array(
            'bold'  => true,
            'size'  => 12,
            'name'  => 'Arial'
        ),
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
        'borders' => array(
            'top'     => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN
            ),'bottom'     => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN
            ),'left'     => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN
            ),'right'     => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN
            )
        ),
    );


    const style_grid_content_left_custom = array(
        'font'  => array(
            'name'  => 'Arial',
            'size'  => 12,
        ),
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
        'borders' => array(
            'top'     => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN
            ),'bottom'     => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN
            ),'left'     => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN
            ),'right'     => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN
            )
        ),
    );

    const style_grid_content_center_custom = array(
        'font'  => array(
            'name'  => 'Arial',
            'size'  => 12,
        ),
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
        'borders' => array(
            'top'     => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN
            ),'bottom'     => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN
            ),'left'     => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN
            ),'right'     => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN
            )
        ),
    );

    const style_grid_content_right_custom = array(
        'font'  => array(
            'name'  => 'Arial',
            'size'  => 12,
        ),
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
        'borders' => array(
            'top'     => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN
            ),'bottom'     => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN
            ),'left'     => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN
            ),'right'     => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN
            )
        ),
    );
    
    
}