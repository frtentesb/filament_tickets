<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Manufacturer;
use Illuminate\Database\Seeder;
use App\Enums\Products\CategoryProductEnum;


class ProductsSeeder extends Seeder
{
    public function run()
    {

        $manufacturers = Manufacturer::all();

        $products = [
                ['name' => 'Intel Core i9-11900K', 'category' => CategoryProductEnum::PROCESSOR->value, 'price' => 599.99, 'description' => 'Processador de última geração da Intel, com 8 núcleos e 16 threads, ideal para desempenho extremo em jogos e produtividade.'],
                ['name' => 'AMD Ryzen 9 5900X', 'category' => CategoryProductEnum::PROCESSOR->value, 'price' => 749.99, 'description' => 'Processador Ryzen 9 da AMD com 12 núcleos e 24 threads, oferecendo excelente desempenho para multitarefas e jogos.'],
                ['name' => 'Intel Core i7-11700K', 'category' => CategoryProductEnum::PROCESSOR->value, 'price' => 399.99, 'description' => 'Processador Intel de 8 núcleos e 16 threads, oferecendo alto desempenho para jogos e aplicativos exigentes.'],
                ['name' => 'AMD Ryzen 7 5800X', 'category' => CategoryProductEnum::PROCESSOR->value, 'price' => 499.99, 'description' => 'Processador Ryzen 7 com 8 núcleos e 16 threads, ideal para quem busca alto desempenho em jogos e criação de conteúdo.'],
                ['name' => 'Corsair Vengeance LPX 16GB', 'category' => CategoryProductEnum::MEMORY->value, 'price' => 79.99, 'description' => 'Kit de memória RAM DDR4 de 16GB da Corsair, ideal para jogos e multitarefas.'],
                ['name' => 'Kingston HyperX 32GB', 'category' => CategoryProductEnum::MEMORY->value, 'price' => 129.99, 'description' => 'Memória RAM de 32GB da Kingston, ideal para quem busca performance extrema em jogos e trabalho com vídeos e design gráfico.'],
                ['name' => 'Seagate Barracuda 2TB', 'category' => CategoryProductEnum::HARD_DISK->value, 'price' => 69.99, 'description' => 'Disco rígido Seagate Barracuda de 2TB, ideal para armazenamento de grande volume de dados.'],
                ['name' => 'Western Digital Blue 1TB', 'category' => CategoryProductEnum::HARD_DISK->value, 'price' => 49.99, 'description' => 'HD Western Digital de 1TB, ideal para quem precisa de um armazenamento confiável e de boa performance.'],
                ['name' => 'Samsung 970 EVO Plus 1TB SSD', 'category' => CategoryProductEnum::SSD->value, 'price' => 129.99, 'description' => 'SSD Samsung 970 EVO Plus de 1TB, com excelente velocidade de leitura e gravação, perfeito para jogos e edição de vídeos.'],
                ['name' => 'Corsair MP600 1TB NVMe SSD', 'category' => CategoryProductEnum::NVME->value, 'price' => 199.99, 'description' => 'SSD NVMe Corsair MP600 de 1TB, ideal para quem busca desempenho extremo e velocidade em tarefas como jogos e renderização.'],
                ['name' => 'MSI Z590-A PRO', 'category' => CategoryProductEnum::MOTHERBOARD->value, 'price' => 199.99, 'description' => 'Placa-mãe MSI Z590-A PRO com suporte a processadores Intel de 10ª e 11ª geração e suporte a PCIe 4.0.'],
                ['name' => 'Gigabyte B550 AORUS Elite', 'category' => CategoryProductEnum::MOTHERBOARD->value, 'price' => 159.99, 'description' => 'Placa-mãe Gigabyte B550 AORUS Elite com excelente custo-benefício e suporte para AMD Ryzen 3000 e 5000.'],
                ['name' => 'ASUS TUF GAMING Z590-PLUS', 'category' => CategoryProductEnum::MOTHERBOARD->value, 'price' => 249.99, 'description' => 'Placa-mãe ASUS TUF GAMING Z590-PLUS com ótima durabilidade e suporte a overclocking e PCIe 4.0.'],
                ['name' => 'NVIDIA GeForce RTX 3080', 'category' => CategoryProductEnum::GRAPHICS_CARD->value, 'price' => 799.99, 'description' => 'Placa de vídeo NVIDIA GeForce RTX 3080, ideal para gamers que buscam performance 4K e Ray Tracing.'],
                ['name' => 'Zotac Gaming GeForce RTX 3070', 'category' => CategoryProductEnum::GRAPHICS_CARD->value, 'price' => 599.99, 'description' => 'Placa de vídeo Zotac Gaming GeForce RTX 3070, excelente desempenho para jogos em 1440p e 4K.'],
                ['name' => 'EVGA GeForce GTX 1660 Ti', 'category' => CategoryProductEnum::GRAPHICS_CARD->value, 'price' => 229.99, 'description' => 'Placa de vídeo EVGA GeForce GTX 1660 Ti, ideal para gamers com orçamento mais restrito.'],
                ['name' => 'Cooler Master MWE Gold 750W', 'category' => CategoryProductEnum::POWER_SUPPLY->value, 'price' => 109.99, 'description' => 'Fonte de alimentação Cooler Master MWE Gold 750W, com certificação 80 Plus Gold para eficiência energética.'],
                ['name' => 'Thermaltake Toughpower Grand 850W', 'category' => CategoryProductEnum::POWER_SUPPLY->value, 'price' => 149.99, 'description' => 'Fonte de alimentação Thermaltake Toughpower Grand 850W, ideal para sistemas de alto desempenho.'],
                ['name' => 'Corsair RM1000x 1000W', 'category' => CategoryProductEnum::POWER_SUPPLY->value, 'price' => 179.99, 'description' => 'Fonte de alimentação Corsair RM1000x 1000W, com baixo ruído e alta eficiência energética.'],
                ['name' => 'Corsair iCUE H100i Elite', 'category' => CategoryProductEnum::COOLING->value, 'price' => 169.99, 'description' => 'Sistema de refrigeração líquida Corsair iCUE H100i Elite, com iluminação RGB e excelente desempenho em resfriamento.'],
                ['name' => 'Cooler Master Hyper 212 EVO', 'category' => CategoryProductEnum::COOLING->value, 'price' => 34.99, 'description' => 'Cooler de ar Cooler Master Hyper 212 EVO, conhecido pela sua eficiência e baixo custo.'],
                ['name' => 'Razer Kraken V3', 'category' => CategoryProductEnum::HEADPHONES->value, 'price' => 129.99, 'description' => 'Headset Razer Kraken V3, com áudio surround e confortável para sessões longas de jogos.'],
                ['name' => 'Logitech G Pro X', 'category' => CategoryProductEnum::HEADPHONES->value, 'price' => 149.99, 'description' => 'Headset Logitech G Pro X, com excelente qualidade de áudio e microfone removível.'],
                ['name' => 'Razer DeathAdder V2', 'category' => CategoryProductEnum::MOUSE->value, 'price' => 69.99, 'description' => 'Mouse Razer DeathAdder V2, com design ergonômico e sensor de alta precisão para gamers.'],
                ['name' => 'Logitech G502 HERO', 'category' => CategoryProductEnum::MOUSE->value, 'price' => 79.99, 'description' => 'Mouse Logitech G502 HERO, com 11 botões programáveis e sensor de 25.000 DPI.'],
                ['name' => 'SteelSeries Rival 600', 'category' => CategoryProductEnum::MOUSE->value, 'price' => 79.99, 'description' => 'Mouse SteelSeries Rival 600, com sensor duplo e design com peso ajustável.'],
                ['name' => 'Corsair K95 RGB Platinum', 'category' => CategoryProductEnum::KEYBOARD->value, 'price' => 199.99, 'description' => 'Teclado Corsair K95 RGB Platinum, com switches mecânicos Cherry MX e retroiluminação RGB.'],
                ['name' => 'Logitech G Pro X', 'category' => CategoryProductEnum::KEYBOARD->value, 'price' => 129.99, 'description' => 'Teclado mecânico Logitech G Pro X, com switches removíveis e RGB personalizável.'],
                ['name' => 'MSI Vigor GK50 Elite', 'category' => CategoryProductEnum::KEYBOARD->value, 'price' => 79.99, 'description' => 'Teclado mecânico MSI Vigor GK50 Elite, com switches mecânicos e retroiluminação RGB.'],
                ['name' => 'BenQ ZOWIE XL2546', 'category' => CategoryProductEnum::MONITOR->value, 'price' => 349.99, 'description' => 'Monitor BenQ ZOWIE XL2546 de 24.5", ideal para jogos competitivos com taxa de atualização de 240Hz.'],
                ['name' => 'Acer Predator XB273K', 'category' => CategoryProductEnum::MONITOR->value, 'price' => 649.99, 'description' => 'Monitor Acer Predator XB273K de 27", com resolução 4K e taxa de atualização de 144Hz, ideal para gamers.'],
                ['name' => 'LG 27GN950-B', 'category' => CategoryProductEnum::MONITOR->value, 'price' => 499.99, 'description' => 'Monitor LG 27GN950-B de 27", com resolução 4K, HDR10 e taxa de atualização de 144Hz.'],
                ['name' => 'Adobe Photoshop', 'category' => CategoryProductEnum::SOFTWARE->value, 'price' => 239.99, 'description' => 'Software de edição de imagens profissional, amplamente utilizado por designers e fotógrafos.'],
                ['name' => 'Microsoft Office 365', 'category' => CategoryProductEnum::SOFTWARE->value, 'price' => 149.99, 'description' => 'Pacote de aplicativos de produtividade da Microsoft, incluindo Word, Excel e PowerPoint.'],
                ['name' => 'Autodesk AutoCAD', 'category' => CategoryProductEnum::SOFTWARE->value, 'price' => 1699.99, 'description' => 'Software de desenho e modelagem 2D e 3D para engenharia e arquitetura.'],
                ['name' => 'Norton 360', 'category' => CategoryProductEnum::SOFTWARE->value, 'price' => 49.99, 'description' => 'Antivírus completo e proteção online com funcionalidades de backup e VPN.'],
                ['name' => 'JetBrains PhpStorm', 'category' => CategoryProductEnum::SOFTWARE->value, 'price' => 199.99, 'description' => 'IDE de desenvolvimento PHP com suporte a frameworks populares, depuração e refatoração de código.'],
                ['name' => 'Kaspersky Total Security', 'category' => CategoryProductEnum::SOFTWARE->value, 'price' => 59.99, 'description' => 'Pacote de segurança completo com antivírus, proteção contra ransomware e monitoramento online.'],
                ['name' => 'SAP S/4HANA', 'category' => CategoryProductEnum::SOFTWARE->value, 'price' => 30000.00, 'description' => 'Software ERP de última geração da SAP, usado para gestão empresarial em grande escala.'],
                ['name' => 'Oracle Database', 'category' => CategoryProductEnum::SOFTWARE->value, 'price' => 20000.00, 'description' => 'Sistema de gerenciamento de banco de dados relacional de alto desempenho da Oracle.'],
                ['name' => 'VMware vSphere', 'category' => CategoryProductEnum::SOFTWARE->value, 'price' => 1999.99, 'description' => 'Plataforma de virtualização de servidores e infraestrutura de TI.'],
                ['name' => 'Slack', 'category' => CategoryProductEnum::SOFTWARE->value, 'price' => 6.67, 'description' => 'Ferramenta de comunicação empresarial para equipes, com integração com diversas plataformas.'],
                ['name' => 'Zoom Video Communications', 'category' => CategoryProductEnum::SOFTWARE->value, 'price' => 14.99, 'description' => 'Software de videoconferência popular para reuniões e eventos online.']
        ];

        // Atribuindo um fabricante aleatório a cada produto
        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'category' => $product['category'],
                'price' => $product['price'],
                'description' => $product['description'],
                'manufacturer_id' => $manufacturers->random()->id, // Associa um fabricante aleatório
            ]);
        }

    }
}
