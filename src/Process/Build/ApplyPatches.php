<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\MagentoCloud\Process\Build;

use Magento\MagentoCloud\Package\MagentoVersion;
use Magento\MagentoCloud\Process\ProcessInterface;
use Magento\MagentoCloud\Shell\ShellInterface;
use Psr\Log\LoggerInterface;

/**
 * @inheritdoc
 */
class ApplyPatches implements ProcessInterface
{
    /**
     * @var ShellInterface
     */
    private $shell;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var MagentoVersion
     */
    private $magentoVersion;

    /**
     * @param ShellInterface $shell
     * @param LoggerInterface $logger
     * @param MagentoVersion $magentoVersion
     */
    public function __construct(
        ShellInterface $shell,
        LoggerInterface $logger,
        MagentoVersion $magentoVersion
    ) {
        $this->shell = $shell;
        $this->logger = $logger;
        $this->magentoVersion = $magentoVersion;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $this->logger->info('Applying patches.');

        try {
            if ($this->magentoVersion->isGreaterOrEqual('2.2')) {
                $this->shell->execute('php vendor/bin/m2-apply-patches');
            }
        } catch (\Exception $exception) {
            $this->logger->warning('Patching was failed. Skipping.');
        }
    }
}