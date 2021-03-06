<?php 
use Dompdf\Dompdf;
class Pdf extends Dompdf{
    public function generate($html,$filename){
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $dompdf->stream($filename.'.pdf',array("Attachment"=>0));
    }
    public function save($html, $filename="", $folder, $paper = 'A4', $orientation = "portrait"){ 
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents($folder.$filename, $output);
    }
}