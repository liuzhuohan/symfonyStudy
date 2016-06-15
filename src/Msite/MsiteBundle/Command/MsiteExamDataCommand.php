<?php
/**
 * Created by PhpStorm.
 * User: xinxiguanli
 * Date: 16/6/3
 * Time: 上午11:43
 */

namespace Msite\MsiteBundle\Command;

use Msite\MsiteBundle\Entity\AppExamMapping;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class MsiteExamDataCommand extends ContainerAwareCommand
{
    /**
     * @{@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('msite:examData')
            ->addOption(
                'import',
                'in',
                InputOption::VALUE_NONE,
                '作为Router/Dealer工作'
            )
            ->addOption(
                'sync',
                'sync',
                InputOption::VALUE_NONE,
                '作为worker工作'
            )
            ->addOption(
                'pinyinShortCut',
                'out',
                InputOption::VALUE_NONE,
                '考试名称转为首字母拼音缩写'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $options = $input->getOptions();
        $option = array_search('true', $input->getOptions());
        $input = $input->getOption('import');
        switch ($option) {
            case 'import':
                $this->import($output);
                break;
            case 'sync':
                break;
            case 'pinyinShortCut':
                break;
            default:
                return;
        }

//        switch (true) {
//            case 'import':
//                $output->writeln("<info>Run as Router !</info>");
//                $this->runAsRouter();
//                break;
//            case $isWorker:
//                $output->writeln("<info>Run as Worker !</info>");
//                $this->runAsWorker('work01');
//                break;
//            default:
//                break;
//        }
        $output->writeln("import exam data into Database");

    }

    /**
     * {@inheritdoc}
     */
    protected function import(OutputInterface $output)
    {
        $pinyin = new Pinyin();
        $errorTable = new Table($output);
//        $request = $this->getContainer()->get('http_client')->createRequest(
//            'GET',
//            'http://kjapi.edu24ol.com/qbox_api/v1/categories/get_all_categories'
//        );
        $client = new Client();

        $request = $client->createRequest('GET', 'http://kjapi.edu24ol.com/qbox_api/v1/categories/get_all_categories');
        $response = $client->send($request);
        $body = $response->getBody(true);
        $result = json_decode($body, true);
        $repo = $this->getContainer()->get('doctrine')->getRepository('MsiteBundle:AppExamMapping');
        $em = $this->getContainer()->get('doctrine')->getManagerForClass('MsiteBundle:AppExamMapping');
        $status = $result['status'];
        $errorTable = new Table($output);
        if ($status['code'] == 0) {
            $data = $result['data'];
            foreach ($data as $item) {
                if ($item['level'] == 2) {
                    $exam = $repo->findOneby(
                        [
                            'examid'=>$item['id']
                        ]
                    );
                    if (!empty($exam))
                        continue;
                    $AppExamMapping = new AppExamMapping();
                    $AppExamMapping->setExamid($item['id']);
                    $AppExamMapping->setCategoryid($item['parent_id']);
                    $AppExamMapping->setDescrption($item['name']);
                    $AppExamMapping->setExamname($pinyin->abbr($item['name']));
                    try {
                        $em->persist($AppExamMapping);
                        $em->flush();
                    } catch (\Exception $e) {
                        $errorTable->addRow($item);
                        continue;
                    }
                }
            }
        }
    }
}