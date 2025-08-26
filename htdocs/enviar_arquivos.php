<?php
require('libs/tcpdf/tcpdf.php');
require_once('config.php');


//classe auxiliar para footer e frases com negrito
class UFRN_PDF extends TCPDF {

    // Footer personalizado
    function Footer() {
        $this->SetY(-15); // Posiciona 25mm do final da página
        
        $this->SetFont('Times', '', 10);        
        $this->Cell(0, 5, utf8_decode('Campus Universitário BR-101 - Lagoa Nova - Natal/RN - CEP 59078-900'), 0, 1, 'C');
        
        $this->Cell(0, 5, utf8_decode('Contato: +55 84 3215-3883 - ouvidoria@ufrn.br'), 0, 1, 'C');
    }
}


date_default_timezone_set('America/Bahia');

if(isset($_POST["enviar"])) {
    // Coleta e sanitiza os dados do formulário
    $nomeResidente = filter_input(INPUT_POST, "nomeResidente", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nomeVisita = filter_input(INPUT_POST, "nomeVisita", FILTER_SANITIZE_SPECIAL_CHARS);
    $MatriculaResidente = filter_input(INPUT_POST, 'matriculaResidente', FILTER_SANITIZE_SPECIAL_CHARS);
    $CPFVisita = filter_input(INPUT_POST, "CPFVisita", FILTER_SANITIZE_SPECIAL_CHARS);
    $quartoResidente = filter_input(INPUT_POST, "campus", FILTER_SANITIZE_SPECIAL_CHARS);
    $data = date('d/m/Y');
    $hora = date('H:i');
    // Cria PDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->setPrintHeader(false);   
    $pdf->AddPage();
    $pdf->SetMargins(30, 20, 26);
    $image_file='Logo.png';
//    $pdf->Image($image_file, 15, 15, 15, 15, '', '','', true, 300, 'C', true, false, 0, false, false, false);
    $pdf->Image($image_file, 96, 20, 20, 20, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);

    $pdf->ln(26);
    // HTML completo para o conteúdo do PDF
    $html = '
    <style>
        body { font-family: times; font-size: 12pt; }
        .header { text-align: center; font-weight: bold; padding: 1mm; }
        .protocolo { margin-bottom: 10mm; font-weight: bold;}
        .data { text-align: right; }
        .destinatario { margin-top: 15mm; margin-bottom: 5mm; }
        .assunto { margin-bottom: 5mm; }
        .corpo-texto { text-align: justify; margin-bottom: 5mm;}
        .negrito { font-weight: bold; }
        .assinatura { margin-top: 20mm; }
        </style>
        <body>

    <div class="header">
    MINISTÉRIO DA EDUCAÇÃO<br>
    UNIVERSIDADE FEDERAL DO RIO GRANDE DO NORTE<br>
    PRÓ-REITORIA DE ASSUNTOS ESTUDANTIS (PROAE) (11.31)
    </div>';
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->ln(23);
    
    $html = '
    <head>
        <style>
        body { font-family: times; font-size: 12pt;}
        .header { text-align: center; font-weight: bold; padding: 1mm; }
        .protocolo { margin-bottom: 10mm; font-weight: bold;}
        .data { text-align: right; }
        .destinatario { margin-top: 15mm; margin-bottom: 5mm; }
        .assunto { margin-bottom: 5mm; }
        .corpo-texto { text-align: justify; margin-bottom: 5mm; text-indent: -11;}
        .negrito { font-weight: bold; }
        .text-cinza{color:gray; font-size: 10pt;}
        .assinatura { margin-top: 20mm; text-align:center;}
    </style>
    </head>


    <body>
    <div class="protocolo">
    OFÍCIO N° 605/2025/PROAE/REITORIA/UFRN<br>
    Nº do Protocolo: 23077.062445/2025-51
    </div>
    
    <div class="data">
        Natal, '.$data_atual.'
    </div>
    
    <div class="destinatario">
        <p><br>Destinatário(s):<br>
        <span class="negrito">PROAE - DIVISÃO DE GESTÃO DAS RESIDÊNCIAS UNIVERSITÁRIAS</span><br>
        <span class="negrito">DIRETORIA DE SEGURANÇA PATRIMONIAL</span></p>
    </div>


    <div class="assunto">
        <p><span class="negrito">Assunto: Autorização de visita na residência universitária Campus III - '.$nomeVisita.'</span></p><br><br><br><br>
    </div>
    
    <div class="corpo-texto">
        <p>Prezado(a),</p>
    </div>



    <div class="corpo-texto">
        Pelo presente, ficam autorizado(a) <span class="negrito">'.$nomeVisita.'</span>, CPF N° <span class="negrito">'.$CPFVisita.'</span>, 
        a visitar no dia <span class="negrito">'.$data.'</span> a partir das <span class="negrito">09h00min</span>, 
        o(a) estudante <span class="negrito">'.$nomeResidente.'</span>, matrícula <span class="negrito">'.$MatriculaResidente.'</span>, 
        residente da <span class="negrito">Residência Universitária '.$quartoResidente.'</span>.
    </div>
    
    <div class="corpo-texto">
        A presente autorização refere-se ao acesso da visita as áreas comuns da supracitada Residência Universitária.
    </div>
    
    <div class="corpo-texto">
        Informamos também que a visita <span class="negrito">não está autorizada a permanecer para pernoite na residência</span>.
        <span class="negrito">Entende-se por pernoite a permanência da visita nas instalações da residência após às 23:59:59.</span>
    </div>
    
    <div class="corpo-texto">
        Entretanto, independente do horário da visita, fica o visitante autorizado a permanecer no pátio da residência 
        enquanto espera serviço de aplicativo de transporte ou possível carona para deixar a residência universitária.
    </div>
    
    <div class="corpo-texto">
        Compromete-se o(a) estudante/residente a orientar o(a) visitante em relação as regras de distanciamento social 
        e a obedecer as orientações que lhe forem prestadas pelos(as) Conselheiros(as) e pela Vigilância do local, 
        tendo como referência os preceitos contidos no Regimento para Funcionamento das Residências Universitárias 
        (Resolução nº 046/2013-CONSAD). O(a) visitante estará sob a responsabilidade do residente, acima informado, 
        enquanto permanecer nas dependências comuns da Residência Universitária.
    </div>
    
    <div class="corpo-texto">
        <p>Atenciosamente,</p><br><br><br><br>
    </div>

    <div class="assinatura">
        <span class="text-cinza">(Autenticado em '.$data.' '.$hora.')<br> </span>
        JOSE PEREIRA DE MELO<br>
        Pro-reitor(a) - Substituto<br>
        Matrícula: 1149620<br>
    </div>
    ';
    // Escreve o HTML no PDF
    
    $pdf->writeHTML($html, true, false, true, false, '');
    
    // Saída do PDF
    $pdf->Output('registro_visita_'.date('Ymd_His').'.pdf', 'D');
    exit;
    
} else {
    header('Location: formulario.php');
    exit;
}
?>