<?php

require_once __DIR__ . '/../models/User.php';

class XmlController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // Exibir página de gerenciamento XML
    public function index()
    {
        $title = 'Gerenciamento XML - Import/Export';
        include __DIR__ . '/../views/xml/index.php';
    }

    // Exportar todos os usuários para XML
    public function export()
    {
        try {
            $users = $this->userModel->getAll();
            
            // Criar documento XML
            $xml = new DOMDocument('1.0', 'UTF-8');
            $xml->formatOutput = true;
            
            // Elemento raiz
            $root = $xml->createElement('usuarios');
            $xml->appendChild($root);
            
            // Adicionar cada usuário
            foreach ($users as $user) {
                $userElement = $xml->createElement('usuario');
                
                $userElement->appendChild($xml->createElement('id', htmlspecialchars($user['id'])));
                $userElement->appendChild($xml->createElement('nome', htmlspecialchars($user['nome'])));
                $userElement->appendChild($xml->createElement('email', htmlspecialchars($user['email'])));
                $userElement->appendChild($xml->createElement('telefone', htmlspecialchars($user['telefone'])));
                $userElement->appendChild($xml->createElement('data_nascimento', htmlspecialchars($user['data_nascimento'])));
                $userElement->appendChild($xml->createElement('created_at', htmlspecialchars($user['created_at'])));
                $userElement->appendChild($xml->createElement('updated_at', htmlspecialchars($user['updated_at'])));
                
                $root->appendChild($userElement);
            }
            
            // Configurar headers para download
            $filename = 'usuarios_' . date('Y-m-d_H-i-s') . '.xml';
            header('Content-Type: application/xml');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: must-revalidate');
            
            echo $xml->saveXML();
            exit;
            
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erro ao exportar XML: ' . $e->getMessage();
            header('Location: /xml');
            exit;
        }
    }

    // Importar usuários de arquivo XML
    public function import()
    {
        try {
            if (!isset($_FILES['xml_file']) || $_FILES['xml_file']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('Erro no upload do arquivo XML');
            }
            
            $xmlFile = $_FILES['xml_file']['tmp_name'];
            $fileExtension = pathinfo($_FILES['xml_file']['name'], PATHINFO_EXTENSION);
            
            if (strtolower($fileExtension) !== 'xml') {
                throw new Exception('Arquivo deve ser do tipo XML');
            }
            
            // Carregar e validar XML
            $xml = new DOMDocument();
            $xml->load($xmlFile);
            
            // Validar estrutura básica
            $usuarios = $xml->getElementsByTagName('usuario');
            if ($usuarios->length === 0) {
                throw new Exception('Arquivo XML não contém usuários válidos');
            }
            
            $importados = 0;
            $erros = [];
            
            foreach ($usuarios as $usuario) {
                try {
                    $userData = [
                        'nome' => $this->getXmlValue($usuario, 'nome'),
                        'email' => $this->getXmlValue($usuario, 'email'),
                        'telefone' => $this->getXmlValue($usuario, 'telefone'),
                        'data_nascimento' => $this->getXmlValue($usuario, 'data_nascimento')
                    ];
                    
                    // Validar dados
                    $validationErrors = $this->userModel->validate($userData);
                    if (!empty($validationErrors)) {
                        $erros[] = "Usuário {$userData['nome']}: " . implode(', ', $validationErrors);
                        continue;
                    }
                    
                    // Verificar se email já existe
                    if ($this->userModel->emailExists($userData['email'])) {
                        $erros[] = "Email {$userData['email']} já existe no sistema";
                        continue;
                    }
                    
                    // Criar usuário
                    $result = $this->userModel->create($userData);
                    if ($result) {
                        $importados++;
                    } else {
                        $erros[] = "Erro ao criar usuário {$userData['nome']}";
                    }
                    
                } catch (Exception $e) {
                    $erros[] = "Erro no usuário: " . $e->getMessage();
                }
            }
            
            // Mensagem de resultado
            $message = "Importação concluída: {$importados} usuário(s) importado(s)";
            if (!empty($erros)) {
                $message .= ". Erros: " . implode('; ', array_slice($erros, 0, 3));
                if (count($erros) > 3) {
                    $message .= " (+" . (count($erros) - 3) . " erros)";
                }
            }
            
            if ($importados > 0) {
                $_SESSION['success'] = $message;
            } else {
                $_SESSION['error'] = $message;
            }
            
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erro na importação: ' . $e->getMessage();
        }
        
        header('Location: /xml');
        exit;
    }

    // Gerar XML de exemplo para download
    public function exemplo()
    {
        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;
        
        $root = $xml->createElement('usuarios');
        $xml->appendChild($root);
        
        // Usuário de exemplo
        $userElement = $xml->createElement('usuario');
        $userElement->appendChild($xml->createElement('nome', 'João da Silva'));
        $userElement->appendChild($xml->createElement('email', 'joao.exemplo@email.com'));
        $userElement->appendChild($xml->createElement('telefone', '(11) 99999-0000'));
        $userElement->appendChild($xml->createElement('data_nascimento', '1990-01-15'));
        $root->appendChild($userElement);
        
        // Segundo usuário de exemplo
        $userElement2 = $xml->createElement('usuario');
        $userElement2->appendChild($xml->createElement('nome', 'Maria dos Santos'));
        $userElement2->appendChild($xml->createElement('email', 'maria.exemplo@email.com'));
        $userElement2->appendChild($xml->createElement('telefone', '(11) 88888-0000'));
        $userElement2->appendChild($xml->createElement('data_nascimento', '1985-05-22'));
        $root->appendChild($userElement2);
        
        header('Content-Type: application/xml');
        header('Content-Disposition: attachment; filename="exemplo_usuarios.xml"');
        header('Cache-Control: must-revalidate');
        
        echo $xml->saveXML();
        exit;
    }

    private function getXmlValue($element, $tagName)
    {
        $nodes = $element->getElementsByTagName($tagName);
        return $nodes->length > 0 ? trim($nodes->item(0)->textContent) : '';
    }
}
