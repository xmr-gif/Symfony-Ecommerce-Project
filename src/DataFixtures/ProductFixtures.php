<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var Category $wholeBeanCategory */
        $wholeBeanCategory = $this->getReference('category_whole-bean', Category::class);

        $products = [
            [
                'name' => 'Yirgacheffe Bloom',
                'slug' => 'yirgacheffe-bloom',
                'description' => 'A bright, complex profile with notes of roasted almond, wild honey, and a hint of stone fruit. Sourced directly from small-batch farmers, this roast is designed to awaken the senses without the bitterness of traditional commercial blends.',
                'price' => '24.00',
                'imageUrl' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD1gFoQojz90Pb9_dySifnSnBv_A3BbIpWfME7jGYjyUuAueIY_uPhoLhvZX9FLIaZo8m2gE0m0AHSdPhY7eDG0sRDkhK1qZ8S1z60Gxia5FJXRaMvazYbFBe-Wzk_SW_gmKt3w9EG-A0lpJxO-ObGf53Q_97pCylVie1sonFJQDvuTCduzxNbLoeZhB8rQnHPDGl_zYPdHoRahq4UtlePe9Bw0_f-_nuhadAG-fYsgrU_7KpBBsfgsNOFQcYbpxINEXnVPPv1wbKGC',
                'badge' => 'Single Origin',
                'tastingNotes' => 'Notes of jasmine, lemon, and peach',
                'sku' => 'ER-YB-01',
                'inStock' => true,
                'origin' => 'Ethiopia',
                'roastLevel' => 'Light Roast',
            ],
            [
                'name' => 'Antigua Velvet',
                'slug' => 'antigua-velvet',
                'description' => 'A smooth, velvety roast from the Antigua region. Rich and decadent with deep chocolate and nutty undertones.',
                'price' => '22.00',
                'imageUrl' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBJSlx14qovWV2EbvAY_YhMvHGozq5N5DhSNPjPdMEepUkUu4TJnwAfX_r4iTVAIwbokO7rZMZV6wBhTJTM_fcoHKusPMeGmwcdQg7cyWkLVc33gkvUmdq4tMPYLZIlhoKxlxqtUBffGSKvoQV9_vH2C7k2pRVXTO6l7XUsZeZpvEPII8FFdAAbEtYZTToDVYrn9_3NM0hZ3OpptZlv0Rgs6b4C6tm6b5m2A8jSkNJdfUM3VSC_ocTrkKI_C7z6f4aEKpyU1FRvvBfi',
                'badge' => 'Limited Batch',
                'tastingNotes' => 'Milk chocolate, almond, and brown sugar',
                'sku' => 'ER-AV-02',
                'inStock' => true,
                'origin' => 'Guatemala',
                'roastLevel' => 'Medium Roast',
            ],
            [
                'name' => 'Sumatra Dark Moon',
                'slug' => 'sumatra-dark-moon',
                'description' => 'Intense and full-bodied. This dark roast brings out the earthy, woody characteristics famous in Sumatran coffees.',
                'price' => '26.00',
                'imageUrl' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAiDIi3dQKSe4yQfkc5zJ0gxDtiC-ZWV8Jn3DWHhNxWEduHNnndAh15VbhntVbT2swKCZzrd-sk7F3s3rpiRzdidNy05ofIZMsBv-88Lqd6i9j8aGHg0N4gsTSz_N_bK0mrtB6EvWgAiep2aRbOWXgUwt4n_k8SaZjTX2e9tiqDatDergPsBJ0niR0nre_ZTyozsTd397bjdcbfzFSxx9OGmJ8zpZZjT8L0MkuDX1NUdeqDi72fFnnQvCm4CmdXSrQLoPSxRcN5qyRG',
                'badge' => null,
                'tastingNotes' => 'Earthy, cedar, and dark chocolate',
                'sku' => 'ER-SDM-03',
                'inStock' => true,
                'origin' => 'Indonesia',
                'roastLevel' => 'Dark Roast',
            ],
            [
                'name' => 'Nariño Reserve',
                'slug' => 'narino-reserve',
                'description' => 'A beautifully balanced Colombian coffee with a distinct honey sweetness and a clean, lingering finish.',
                'price' => '21.00',
                'imageUrl' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuByA3p7EtxPanbipS7x5bd36Py4AUYSy2V5INPW1xDORqwyVKP_iKycq74XpwPrcyO96kMlgnyBlb4DgZOznYK9Ba4r9OIC_mppvB7BsHuQjTq8qfl3E5ka2hbhhCxS4Z0cFHu6NBnvIBlyW3nSG5xzjeMJ9OfdajsqdCyfEmxB3Iwl6QSTfjgzb9CfSwRN5TONrHq_eoyCvUOSgMUA1YdZ7_us17O0cFInAqmeQ8jt3VH8Oy2EvmjdJtBgoxruZpGeMuKRhYV7HG2z',
                'badge' => null,
                'tastingNotes' => 'Balanced acidity with honey sweetness',
                'sku' => 'ER-NR-04',
                'inStock' => true,
                'origin' => 'Colombia',
                'roastLevel' => 'Medium Roast',
            ],
            [
                'name' => 'Cerrado Gold',
                'slug' => 'cerrado-gold',
                'description' => 'A classic Brazilian profile. Low acidity, heavy body, and an unmistakable nutty flavor profile perfect for espresso.',
                'price' => '19.00',
                'imageUrl' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAkmgelYubQOcnUaR6_iQMi7MJWaRIO0bfBVKbGBNKlXBHe2mMY03XdLWGWd2irVJjWe9X15JrR4gWtEXpqVRpkjBPcYVZkMRGSH67PStglfBSMsxKh-aY96Q5lFY53pH58k_0mDKQYasuzcxES6KqFDRrXFIPujxaLMlMJ93pP4k5QMZjazkRASnSGsWdMezAkOMJ9lRhQjR1uKhfaA0A34AvSvu5BE9TBgxPF9VIISnt-QvEkELWNj_3S6vs4-HHQ46STz1-hmpdE',
                'badge' => 'Direct Trade',
                'tastingNotes' => 'Nutty profile with low acidity',
                'sku' => 'ER-CG-05',
                'inStock' => true,
                'origin' => 'Brazil',
                'roastLevel' => 'Medium Roast',
            ],
            [
                'name' => 'Sidamo Sun',
                'slug' => 'sidamo-sun',
                'description' => 'A naturally processed Ethiopian coffee bursting with bright berry flavors and a wine-like acidity.',
                'price' => '25.00',
                'imageUrl' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBVUW1f1-ZjN2dHluGzZOQ0kJiJX4tl9GnzBbr2vTZ3xu4KB980Lb2o3NO3irxOrJ3iN90-tR8TvQBXK80sb1EFUfoGUqm6x26P8z5IVqBPz8UvCMHsBGlpU7I6z9xLWeQ06vWuUBoZ-wIH2IPXMA4Yb8znICmGK4Uu6psiQjZ4VGFCRes4QeIZNq5zLY5ZXLOgkdimVvzTRKYLhC0nGyp64kfNi6kIrNDvxyTScrfjDmBGUmro3Sw85TrfiIXqKsSSby4jb8rVxhp5',
                'badge' => null,
                'tastingNotes' => 'Fruity, bright, and wine-like',
                'sku' => 'ER-SS-06',
                'inStock' => true,
                'origin' => 'Ethiopia',
                'roastLevel' => 'Light Roast',
            ],
        ];

        foreach ($products as $data) {
            $product = new Product();
            $product->setName($data['name']);
            $product->setSlug($data['slug']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);
            $product->setImageUrl($data['imageUrl']);
            $product->setBadge($data['badge']);
            $product->setTastingNotes($data['tastingNotes']);
            $product->setSku($data['sku']);
            $product->setInStock($data['inStock']);
            $product->setOrigin($data['origin']);
            $product->setRoastLevel($data['roastLevel']);
            
            $product->setCategory($wholeBeanCategory);

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
