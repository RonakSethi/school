# PHPExcel

This repo of PHPExcel was created to make it easy to add it to Symfony2 projects.
It contains the unchanged sourcecode that can be found on http://phpexcel.codeplex.com/.
Current version (of PHPExcel in this repo) is 1.7.6.

Documentation and Test files are not included here, you can find them on http://phpexcel.codeplex.com/.

## Installation and configuration for Symfony2

### 1) Get the files

To use PHPExcel in Symfony2, you need to add the files to the vendor directory

Add to your `/deps` file :

```
[PHPExcel]
    git=http://github.com/logiQ/PHPExcel.git
    target=/phpexcel
    version=v1.7.6
```

Now, run the vendors script to download the files to your vendor directory:

``` bash
$ php bin/vendors install
```

### 2) Configure the Autoloader

Add the 'PHPExcel' prefix to your autoloader:

``` php
<?php
// app/autoload.php
$loader->registerPrefixes(array(
    // ...
    'PHPExcel'         => __DIR__.'/../vendor/phpexcel/Classes/'
));
```

### 3) Use it in your project

*Below code is based on the file "01simple-download-xls.php" in the /Tests directory (not included in this repo)*

``` php
<?php
// ...

class SomeController
{
    public function someExcelAction()
    {
        // Create new PHPExcel object
        $objPHPExcel = new \PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        							 ->setLastModifiedBy("Maarten Balliauw")
        							 ->setTitle("Office 2007 XLSX Test Document")
        							 ->setSubject("Office 2007 XLSX Test Document")
        							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        							 ->setKeywords("office 2007 openxml php")
        							 ->setCategory("Test result file");


        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Hello')
                    ->setCellValue('B2', 'world!')
                    ->setCellValue('C1', 'Hello')
                    ->setCellValue('D2', 'world!');

        // Miscellaneous glyphs, UTF-8
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A4', 'Miscellaneous glyphs')
                    ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Simple');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="01simple.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
}
```
