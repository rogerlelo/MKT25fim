<?php

use CodeEmailMKT\Application\Action\Customer\{CustomerListPageAction,CustomerCreatePageAction,CustomerUpdatePageAction,CustomerDeletePageAction};
use CodeEmailMKT\Application\Action\Customer\Factory as Customer;
use CodeEmailMKT\Application\Action\Campaign\{CampaignListPageAction,CampaignCreatePageAction,CampaignUpdatePageAction,CampaignDeletePageAction,CampaignSenderPageAction,CampaignReportPageAction};
use CodeEmailMKT\Application\Action;
use CodeEmailMKT\Application\Middleware;///ccccc

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\AuraRouter::class,
        ],
        'factories' => [
            Action\LoginPageAction::class => Action\LoginPageFactory::class,
            Action\LogoutAction::class => Action\LogoutFactory::class,
            CustomerListPageAction::class => Customer\CustomerListPageFactory::class,
            CustomerCreatePageAction::class => Customer\CustomerCreatePageFactory::class,
            CustomerUpdatePageAction::class => Customer\CustomerUpdatePageFactory::class,
            CustomerDeletePageAction::class => Customer\CustomerDeletePageFactory::class,
            Action\Tag\TagListPageAction::class => Action\Tag\Factory\TagListPageFactory::class,
            Action\Tag\TagCreatePageAction::class => Action\Tag\Factory\TagCreatePageFactory::class,
            Action\Tag\TagUpdatePageAction::class => Action\Tag\Factory\TagUpdatePageFactory::class,
            Action\Tag\TagDeletePageAction::class => Action\Tag\Factory\TagDeletePageFactory::class,
            CampaignListPageAction::class => Action\Campaign\Factory\CampaignListPageFactory::class,
            CampaignCreatePageAction::class => Action\Campaign\Factory\CampaignCreatePageFactory::class,
            CampaignUpdatePageAction::class => Action\Campaign\Factory\CampaignUpdatePageFactory::class,
            CampaignDeletePageAction::class => Action\Campaign\Factory\CampaignDeletePageFactory::class,
            CampaignSenderPageAction::class => Action\Campaign\Factory\CampaignSenderPageFactory::class,
            CampaignReportPageAction::class => Action\Campaign\Factory\CampaignReportPageFactory::class
        ],
    ],

    'routes' => [
        [
            'name' => 'home',
            'path' => '/',
            'middleware' => CustomerListPageAction::class,
            'allowed_methods' => ['GET'],
            'middleware' => [ ///cccccccc
                Middleware\AuthenticationMiddleware::class
            ]///cccccccc
        ],
        [
            'name' => 'auth.login',
            'path' => '/auth/login',
            'middleware' => CodeEmailMKT\Application\Action\LoginPageAction::class,
            'allowed_methods' => ['GET','POST'],
        ],
        [
            'name' => 'auth.logout',
            'path' => '/auth/logout',
            'middleware' => CodeEmailMKT\Application\Action\LogoutAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'customer.list',
            'path' => '/admin/customers',
            'middleware' => CustomerListPageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'customer.create',
            'path' => '/admin/customer/create',
            'middleware' => CustomerCreatePageAction::class,
            'allowed_methods' => ['GET','POST'],
        ],
        [
            'name' => 'customer.update',
            'path' => '/admin/customer/update/{id}',
            'middleware' => CustomerUpdatePageAction::class,
            'allowed_methods' => ['GET','PUT'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ],
        ],
        [
            'name' => 'customer.delete',
            'path' => '/admin/customer/delete/{id}',
            'middleware' => CustomerDeletePageAction::class,
            'allowed_methods' => ['GET','DELETE'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [ ///////////////////////////////////////////////
            'name' => 'tag.list',
            'path' => '/admin/tags',
            'middleware' => Action\Tag\TagListPageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'tag.create',
            'path' => '/admin/tag/create',
            'middleware' => Action\Tag\TagCreatePageAction::class,
            'allowed_methods' => ['GET','POST'],
        ],
        [
            'name' => 'tag.update',
            'path' => '/admin/tag/update/{id}',
            'middleware' => Action\Tag\TagUpdatePageAction::class,
            'allowed_methods' => ['GET','PUT'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ],
        ],
        [
            'name' => 'tag.delete',
            'path' => '/admin/tag/delete/{id}',
            'middleware' => Action\Tag\TagDeletePageAction::class,
            'allowed_methods' => ['GET','DELETE'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],////////////////////////////////////////////////////////////
        [ ///////////////////////////////////////////////
            'name' => 'campaign.list',
            'path' => '/admin/campaigns',
            'middleware' => Action\Campaign\CampaignListPageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'campaign.create',
            'path' => '/admin/campaign/create',
            'middleware' => Action\Campaign\CampaignCreatePageAction::class,
            'allowed_methods' => ['GET','POST'],
        ],
        [
            'name' => 'campaign.update',
            'path' => '/admin/campaign/update/{id}',
            'middleware' => Action\Campaign\CampaignUpdatePageAction::class,
            'allowed_methods' => ['GET','PUT'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ],
        ],
        [
            'name' => 'campaign.delete',
            'path' => '/admin/campaign/delete/{id}',
            'middleware' => Action\Campaign\CampaignDeletePageAction::class,
            'allowed_methods' => ['GET','DELETE'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'campaign.sender',
            'path' => '/admin/campaign/sender/{id}',
            'middleware' => CampaignSenderPageAction::class,
            'allowed_methods' => ['GET','POST'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'campaign.report',
            'path' => '/admin/campaign/report/{id}',
            'middleware' => CampaignReportPageAction::class,
            'allowed_methods' => ['GET'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
    ],
];
