<?php

declare(strict_types=1);

namespace App\controller\frontend;

use App\model\Product\ProductRepository;
use Eric\Core\Action;
use Eric\Core\View;
use Exception;

/**
 * Class Product
 */
class Product extends Action
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $template;

    protected $view;

    public function __construct()
    {
        $this->title = "Product Page";
        $this->template = 'product';
    }

    /**
     * @param $args
     * @return void
     * @throws Exception
     */
    public function execute($args)
    {
        $productRepository = new ProductRepository();
        $products = $productRepository->getAll();

        $this->view = new View($this->template);
        $this->view->assign('products', $products);
        $this->view->render();
    }

    /**
     * @param $args
     * @return void
     */
    public function deleteAjax($args)
    {
        $productRepository = new ProductRepository();
        $result = $productRepository->delete($_POST['productId']);

        echo $result;
    }

    /**
     * @param $args
     * @return void
     * @throws Exception
     */
    public function delete($args)
    {
        $this->view = new View($this->template);
        $productRepository = new ProductRepository();

        if (isset($args[0]) && !empty($args[0])) {
            $isDeleted = $productRepository->delete($args['0']);
            if ($isDeleted) {
                $products = $productRepository->getAll();
                $this->view->assign('products', $products);
                $this->view->assign('notices', ["The product id {$args[0]} is deleted successfully"]);
                $this->view->render();
            } else {
                $this->view->assign('errors', ["Can not delete product with id={$args[0]}"]);
            }
        } else {
            $this->view->assign('errors', ["Can not delete product with id={$args[0]}"]);
        }
    }

    /**
     * @param $args
     * @return void
     */
    public function add($args)
    {
        $product = new \App\model\Product\Product();
        $product->setName($_POST['productName']);
        $product->setSku($_POST['sku']);
        $product->setQuantity($_POST['quantity']);

        $productRepository = new ProductRepository();
        $newProduct = $productRepository->add($product);

        echo json_encode($newProduct->toString());
    }

    /**
     * @param $args
     * @return void
     */
    public function editAjax($args)
    {
        if (isset($_POST['productId']) && $_POST['productId']) {
            $productRepository = new \App\model\Product\ProductRepository();
            $product = $productRepository->get($_POST['productId']);
            $product->setName($_POST['productName'] ?? $product->getName());
            $product->setSku($_POST['sku'] ?? $product->getSku());
            $product->setQuantity($_POST['quantity'] ?? $product->getQuantity());
            $updatedProduct = $productRepository->update($product);
            echo json_encode($updatedProduct->toString());
        }
    }
}