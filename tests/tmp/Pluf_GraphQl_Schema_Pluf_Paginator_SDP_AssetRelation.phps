<?php 
// Import
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
/**
 * Render class of GraphQl
 */
class Pluf_GraphQl_Schema_Pluf_Paginator_SDP_AssetRelation { 
    public function render($rootValue, $query) {
        // render object types variables
         $SDP_AssetRelation = null;
         $SDP_Asset = null;
         $CMS_Content = null;
         $User_Account = null;
         $User_Group = null;
         $User_Role = null;
         $Tenant_Comment = null;
         $Tenant_Ticket = null;
         $User_Message = null;
         $User_Profile = null;
         $Bank_Wallet = null;
         $Bank_Transfer = null;
         $Bank_Receipt = null;
         $Bank_Backend = null;
         $Tenant_Invoice = null;
         $Tenant_BankReceipt = null;
         $Tenant_BankBackend = null;
         $Pluf_Tenant = null;
         $SDP_Link = null;
         $SDP_Profile = null;
         $CMS_ContentMeta = null;
         $CMS_TermTaxonomy = null;
         $CMS_Term = null;
         $CMS_TermMeta = null;
         $SDP_Drive = null;
         $SDP_Category = null;
         $SDP_Tag = null;
        // render code
         //
        $SDP_AssetRelation = new ObjectType([
            'name' => 'SDP_AssetRelation',
            'fields' => function () use (&$SDP_Asset){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [is_null] =>     [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //type: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 250    [editable] => 1    [readable] => 1)
                    'type' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->type;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] =>     [editable] =>     [readable] => 1)
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] =>     [editable] =>     [readable] => 1)
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 250    [editable] => 1    [readable] => 1)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //Foreinkey value-start_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => SDP_Asset    [is_null] =>     [name] => start    [graphql_name] => start    [relate_name] => start_relations    [editable] => 1    [readable] => 1)
                    'start_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->start_id;
                            },
                    ],
                    //Foreinkey object-start_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => SDP_Asset    [is_null] =>     [name] => start    [graphql_name] => start    [relate_name] => start_relations    [editable] => 1    [readable] => 1)
                    'start' => [
                            'type' => $SDP_Asset,
                            'resolve' => function ($root) {
                                return $root->get_start();
                            },
                    ],
                    //Foreinkey value-end_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => SDP_Asset    [is_null] =>     [name] => end    [graphql_name] => end    [relate_name] => end_relations    [editable] => 1    [readable] => 1)
                    'end_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->end_id;
                            },
                    ],
                    //Foreinkey object-end_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => SDP_Asset    [is_null] =>     [name] => end    [graphql_name] => end    [relate_name] => end_relations    [editable] => 1    [readable] => 1)
                    'end' => [
                            'type' => $SDP_Asset,
                            'resolve' => function ($root) {
                                return $root->get_end();
                            },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $SDP_Asset = new ObjectType([
            'name' => 'SDP_Asset',
            'fields' => function () use (&$SDP_Asset, &$CMS_Content, &$SDP_Drive, &$SDP_Link, &$SDP_Category, &$SDP_Tag){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [is_null] =>     [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //name: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 250    [editable] => 1    [readable] => 1)
                    'name' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->name;
                        },
                    ],
                    //size: Array(    [type] => Pluf_DB_Field_Integer    [is_null] =>     [default] => 0    [editable] =>     [readable] => 1)
                    'size' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->size;
                        },
                    ],
                    //file_name: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [default] => noname    [size] => 256    [editable] => 1    [readable] => 1)
                    'file_name' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->file_name;
                        },
                    ],
                    //download: Array(    [type] => Pluf_DB_Field_Integer    [is_null] =>     [default] => 0    [editable] =>     [readable] => 1)
                    'download' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->download;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] =>     [editable] =>     [readable] => 1)
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] =>     [editable] =>     [readable] => 1)
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    //type: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 250    [editable] =>     [readable] => 1)
                    'type' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->type;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 250    [editable] => 1    [readable] => 1)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //mime_type: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 250    [editable] =>     [readable] => 1)
                    'mime_type' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->mime_type;
                        },
                    ],
                    //price: Array(    [type] => Pluf_DB_Field_Integer    [is_null] =>     [default] => 0    [editable] => 1    [readable] => 1)
                    'price' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->price;
                        },
                    ],
                    //thumbnail: Array(    [type] => Pluf_DB_Field_Varchar    [size] => 1024    [is_null] => 1    [editable] => 1    [readable] => 1)
                    'thumbnail' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->thumbnail;
                        },
                    ],
                    //Foreinkey value-parent_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => SDP_Asset    [name] => parent    [graphql_name] => parent    [relate_name] => children    [is_null] => 1    [editable] => 1    [readable] => 1)
                    'parent_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->parent_id;
                            },
                    ],
                    //Foreinkey object-parent_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => SDP_Asset    [name] => parent    [graphql_name] => parent    [relate_name] => children    [is_null] => 1    [editable] => 1    [readable] => 1)
                    'parent' => [
                            'type' => $SDP_Asset,
                            'resolve' => function ($root) {
                                return $root->get_parent();
                            },
                    ],
                    //Foreinkey value-content_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => CMS_Content    [name] => content    [graphql_name] => content    [relate_name] => assets    [is_null] => 1    [editable] => 1    [readable] => 1)
                    'content_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->content_id;
                            },
                    ],
                    //Foreinkey object-content_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => CMS_Content    [name] => content    [graphql_name] => content    [relate_name] => assets    [is_null] => 1    [editable] => 1    [readable] => 1)
                    'content' => [
                            'type' => $CMS_Content,
                            'resolve' => function ($root) {
                                return $root->get_content();
                            },
                    ],
                    //Foreinkey value-drive_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => SDP_Drive    [is_null] => 1    [relate_name] => assets    [graphql_name] => drive    [editable] =>     [readable] => 1)
                    'drive_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->drive_id;
                            },
                    ],
                    //Foreinkey object-drive_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => SDP_Drive    [is_null] => 1    [relate_name] => assets    [graphql_name] => drive    [editable] =>     [readable] => 1)
                    'drive' => [
                            'type' => $SDP_Drive,
                            'resolve' => function ($root) {
                                return $root->get_drive_id();
                            },
                    ],
                    // relations: forenkey 
                    
                    //Foreinkey list-asset_id: Array()
                    'links' => [
                            'type' => Type::listOf($SDP_Link),
                            'resolve' => function ($root) {
                                return $root->get_links_list();
                            },
                    ],
                    
                    //Foreinkey list-assets: Array()
                    'categories' => [
                            'type' => Type::listOf($SDP_Category),
                            'resolve' => function ($root) {
                                return $root->get_categories_list();
                            },
                    ],
                    //Foreinkey list-assets: Array()
                    'tags' => [
                            'type' => Type::listOf($SDP_Tag),
                            'resolve' => function ($root) {
                                return $root->get_tags_list();
                            },
                    ],
                ];
            }
        ]); //
        $CMS_Content = new ObjectType([
            'name' => 'CMS_Content',
            'fields' => function () use (&$User_Account, &$CMS_Content, &$CMS_ContentMeta, &$CMS_TermTaxonomy){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [is_null] =>     [editable] => )
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //name: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 64    [unique] => 1    [editable] => 1)
                    'name' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->name;
                        },
                    ],
                    //title: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 250    [default] =>     [editable] => 1)
                    'title' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->title;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 2048    [default] => auto created content    [editable] => 1)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //mime_type: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 64    [default] => application/octet-stream    [editable] => 1)
                    'mime_type' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->mime_type;
                        },
                    ],
                    //media_type: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 64    [default] => application/octet-stream    [verbose] => Media type    [help_text] => This types allow you to category contents    [editable] => 1)
                    'media_type' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->media_type;
                        },
                    ],
                    //file_name: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 250    [default] => unknown    [verbose] => file name    [help_text] => Content file name    [editable] => )
                    'file_name' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->file_name;
                        },
                    ],
                    //file_size: Array(    [type] => Pluf_DB_Field_Integer    [is_null] =>     [default] => no title    [verbose] => file size    [help_text] => content file size    [editable] => )
                    'file_size' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->file_size;
                        },
                    ],
                    //downloads: Array(    [type] => Pluf_DB_Field_Integer    [is_null] =>     [default] => 0    [help_text] => content downloads number    [editable] => )
                    'downloads' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->downloads;
                        },
                    ],
                    //status: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 64    [default] => published    [editable] => )
                    'status' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->status;
                        },
                    ],
                    //comment_status: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 64    [default] =>     [editable] => )
                    'comment_status' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->comment_status;
                        },
                    ],
                    //comment_count: Array(    [type] => Pluf_DB_Field_Integer    [is_null] =>     [default] => 0    [help_text] => number of comments on the content    [editable] => )
                    'comment_count' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->comment_count;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [verbose] => creation    [help_text] => content creation time    [editable] => )
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [verbose] => modification    [help_text] => content modification time    [editable] => )
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    //Foreinkey value-author_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [is_null] =>     [name] => author    [relate_name] => cms_contents    [graphql_name] => author    [editable] => )
                    'author_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->author_id;
                            },
                    ],
                    //Foreinkey object-author_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [is_null] =>     [name] => author    [relate_name] => cms_contents    [graphql_name] => author    [editable] => )
                    'author' => [
                            'type' => $User_Account,
                            'resolve' => function ($root) {
                                return $root->get_author();
                            },
                    ],
                    //Foreinkey value-parent_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => CMS_Content    [is_null] => 1    [name] => parent    [graphql_name] => parent    [relate_name] => children    [editable] => 1    [readable] => 1)
                    'parent_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->parent_id;
                            },
                    ],
                    //Foreinkey object-parent_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => CMS_Content    [is_null] => 1    [name] => parent    [graphql_name] => parent    [relate_name] => children    [editable] => 1    [readable] => 1)
                    'parent' => [
                            'type' => $CMS_Content,
                            'resolve' => function ($root) {
                                return $root->get_parent();
                            },
                    ],
                    // relations: forenkey 
                    
                    //Foreinkey list-content_id: Array()
                    'metas' => [
                            'type' => Type::listOf($CMS_ContentMeta),
                            'resolve' => function ($root) {
                                return $root->get_metas_list();
                            },
                    ],
                    
                    //Foreinkey list-contents_ids: Array()
                    'term_taxonomies' => [
                            'type' => Type::listOf($CMS_TermTaxonomy),
                            'resolve' => function ($root) {
                                return $root->get_term_taxonomies_list();
                            },
                    ],
                ];
            }
        ]); //
        $User_Account = new ObjectType([
            'name' => 'User_Account',
            'fields' => function () use (&$User_Group, &$User_Role, &$Tenant_Comment, &$User_Message, &$User_Profile, &$CMS_Content, &$Bank_Wallet, &$Bank_Transfer, &$SDP_Link, &$SDP_Profile){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [is_null] => 1    [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //login: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [unique] => 1    [size] => 50    [editable] =>     [readable] => 1)
                    'login' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->login;
                        },
                    ],
                    //date_joined: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] => 1    [editable] => )
                    'date_joined' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->date_joined;
                        },
                    ],
                    //last_login: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] => 1    [editable] => )
                    'last_login' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->last_login;
                        },
                    ],
                    //is_active: Array(    [type] => Pluf_DB_Field_Boolean    [is_null] =>     [default] =>     [editable] => )
                    'is_active' => [
                        'type' => Type::boolean(),
                        'resolve' => function ($root) {
                            return $root->is_active;
                        },
                    ],
                    //is_deleted: Array(    [type] => Pluf_DB_Field_Boolean    [is_null] =>     [default] =>     [editable] => )
                    'is_deleted' => [
                        'type' => Type::boolean(),
                        'resolve' => function ($root) {
                            return $root->is_deleted;
                        },
                    ],
                    //Foreinkey value-groups: Array(    [type] => Pluf_DB_Field_Manytomany    [blank] => 1    [model] => User_Group    [relate_name] => accounts    [editable] =>     [graphql_name] => groups    [readable] => 1)
                    'groups' => [
                            'type' => Type::listOf($User_Group),
                            'resolve' => function ($root) {
                                return $root->get_groups_list();
                            },
                    ],
                    //Foreinkey value-roles: Array(    [type] => Pluf_DB_Field_Manytomany    [blank] => 1    [relate_name] => accounts    [editable] =>     [model] => User_Role    [graphql_name] => roles    [readable] => 1)
                    'roles' => [
                            'type' => Type::listOf($User_Role),
                            'resolve' => function ($root) {
                                return $root->get_roles_list();
                            },
                    ],
                    // relations: forenkey 
                    
                    //Foreinkey list-author_id: Array()
                    'Tenant_Comment' => [
                            'type' => Type::listOf($Tenant_Comment),
                            'resolve' => function ($root) {
                                return $root->get_Tenant_Comment_list();
                            },
                    ],
                    //Foreinkey list-account_id: Array()
                    'messages' => [
                            'type' => Type::listOf($User_Message),
                            'resolve' => function ($root) {
                                return $root->get_messages_list();
                            },
                    ],
                    //Foreinkey list-account_id: Array()
                    'profiles' => [
                            'type' => Type::listOf($User_Profile),
                            'resolve' => function ($root) {
                                return $root->get_profiles_list();
                            },
                    ],
                    //Foreinkey list-author_id: Array()
                    'cms_contents' => [
                            'type' => Type::listOf($CMS_Content),
                            'resolve' => function ($root) {
                                return $root->get_cms_contents_list();
                            },
                    ],
                    //Foreinkey list-owner_id: Array()
                    'wallets' => [
                            'type' => Type::listOf($Bank_Wallet),
                            'resolve' => function ($root) {
                                return $root->get_wallets_list();
                            },
                    ],
                    //Foreinkey list-acting_id: Array()
                    'wallet_transfers' => [
                            'type' => Type::listOf($Bank_Transfer),
                            'resolve' => function ($root) {
                                return $root->get_wallet_transfers_list();
                            },
                    ],
                    //Foreinkey list-user_id: Array()
                    'links' => [
                            'type' => Type::listOf($SDP_Link),
                            'resolve' => function ($root) {
                                return $root->get_links_list();
                            },
                    ],
                    //Foreinkey list-account_id: Array()
                    'sdp_profiles' => [
                            'type' => Type::listOf($SDP_Profile),
                            'resolve' => function ($root) {
                                return $root->get_sdp_profiles_list();
                            },
                    ],
                    
                ];
            }
        ]); //
        $User_Group = new ObjectType([
            'name' => 'User_Group',
            'fields' => function () use (&$User_Role, &$User_Account){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [blank] => 1    [readable] => 1    [editable] => )
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //name: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 50    [verbose] => name)
                    'name' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->name;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 250    [verbose] => description)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //Foreinkey value-roles: Array(    [type] => Pluf_DB_Field_Manytomany    [model] => User_Role    [is_null] => 1    [editable] =>     [relate_name] => groups    [graphql_name] => roles)
                    'roles' => [
                            'type' => Type::listOf($User_Role),
                            'resolve' => function ($root) {
                                return $root->get_roles_list();
                            },
                    ],
                    // relations: forenkey 
                    
                    
                    //Foreinkey list-groups: Array()
                    'accounts' => [
                            'type' => Type::listOf($User_Account),
                            'resolve' => function ($root) {
                                return $root->get_accounts_list();
                            },
                    ],
                ];
            }
        ]); //
        $User_Role = new ObjectType([
            'name' => 'User_Role',
            'fields' => function () use (&$User_Account, &$User_Group){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [blank] => 1    [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //name: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 50    [verbose] => name)
                    'name' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->name;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 250    [verbose] => description)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //application: Array(    [type] => Pluf_DB_Field_Varchar    [size] => 150    [is_null] =>     [verbose] => application    [help_text] => The application using this permission, for example "YourApp", "CMS" or "SView".)
                    'application' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->application;
                        },
                    ],
                    //code_name: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 100    [verbose] => code name    [help_text] => The code name must be unique for each application. Standard permissions to manage a model in the interface are "Model_Name-create", "Model_Name-update", "Model_Name-list" and "Model_Name-delete".)
                    'code_name' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->code_name;
                        },
                    ],
                    // relations: forenkey 
                    
                    
                    //Foreinkey list-roles: Array()
                    'accounts' => [
                            'type' => Type::listOf($User_Account),
                            'resolve' => function ($root) {
                                return $root->get_accounts_list();
                            },
                    ],
                    //Foreinkey list-roles: Array()
                    'groups' => [
                            'type' => Type::listOf($User_Group),
                            'resolve' => function ($root) {
                                return $root->get_groups_list();
                            },
                    ],
                ];
            }
        ]); //
        $Tenant_Comment = new ObjectType([
            'name' => 'Tenant_Comment',
            'fields' => function () use (&$User_Account, &$Tenant_Ticket){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [blank] =>     [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //title: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [is_null] =>     [size] => 256)
                    'title' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->title;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [is_null] => 1    [size] => 2048)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [is_null] => 1    [editable] =>     [readable] => 1)
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [is_null] => 1    [editable] =>     [readable] => 1)
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    //Foreinkey value-author_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [is_null] =>     [editable] =>     [readable] => 1    [name] => author    [graphql_feild] => author)
                    'author_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->author_id;
                            },
                    ],
                    //Foreinkey value-ticket_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Tenant_Ticket    [is_null] =>     [editable] =>     [readable] => 1    [name] => ticket    [graphql_feild] => ticket)
                    'ticket_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->ticket_id;
                            },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $Tenant_Ticket = new ObjectType([
            'name' => 'Tenant_Ticket',
            'fields' => function () use (&$User_Account){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [blank] =>     [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //type: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [is_null] => 1    [size] => 256)
                    'type' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->type;
                        },
                    ],
                    //subject: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [is_null] =>     [size] => 256)
                    'subject' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->subject;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [is_null] => 1    [size] => 2048)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //status: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [is_null] =>     [size] => 50    [editable] =>     [readable] => 1)
                    'status' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->status;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [is_null] => 1    [editable] =>     [readable] => 1)
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [is_null] => 1    [editable] =>     [readable] => 1)
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    //Foreinkey value-requester_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [blank] =>     [editable] =>     [readable] => 1    [name] => requester    [graphql_name] => requester)
                    'requester_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->requester_id;
                            },
                    ],
                    //Foreinkey object-requester_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [blank] =>     [editable] =>     [readable] => 1    [name] => requester    [graphql_name] => requester)
                    'requester' => [
                            'type' => $User_Account,
                            'resolve' => function ($root) {
                                return $root->get_requester();
                            },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $User_Message = new ObjectType([
            'name' => 'User_Message',
            'fields' => function () use (&$User_Account){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [blank] => 1    [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //Foreinkey value-account_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [name] => account    [graphql_name] => account    [relate_name] => messages    [is_null] =>     [editable] => )
                    'account_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->account_id;
                            },
                    ],
                    //Foreinkey object-account_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [name] => account    [graphql_name] => account    [relate_name] => messages    [is_null] =>     [editable] => )
                    'account' => [
                            'type' => $User_Account,
                            'resolve' => function ($root) {
                                return $root->get_account();
                            },
                    ],
                    //message: Array(    [type] => Pluf_DB_Field_Text    [is_null] =>     [editable] =>     [readable] => 1)
                    'message' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->message;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] => 1    [editable] =>     [readable] => 1)
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $User_Profile = new ObjectType([
            'name' => 'User_Profile',
            'fields' => function () use (&$User_Account){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [is_null] => 1    [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //first_name: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 100)
                    'first_name' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->first_name;
                        },
                    ],
                    //last_name: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 100)
                    'last_name' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->last_name;
                        },
                    ],
                    //public_email: Array(    [type] => Pluf_DB_Field_Email    [is_null] => 1    [editable] =>     [readable] => 1)
                    'public_email' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->public_email;
                        },
                    ],
                    //language: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [default] => en    [size] => 5)
                    'language' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->language;
                        },
                    ],
                    //timezone: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [default] => UTC    [size] => 45    [verbose] => time zone    [help_text] => Time zone of the user to display the time in local time.)
                    'timezone' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->timezone;
                        },
                    ],
                    //Foreinkey value-account_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [name] => account    [relate_name] => profiles    [graphql_name] => account    [is_null] =>     [editable] => )
                    'account_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->account_id;
                            },
                    ],
                    //Foreinkey object-account_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [name] => account    [relate_name] => profiles    [graphql_name] => account    [is_null] =>     [editable] => )
                    'account' => [
                            'type' => $User_Account,
                            'resolve' => function ($root) {
                                return $root->get_account();
                            },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $Bank_Wallet = new ObjectType([
            'name' => 'Bank_Wallet',
            'fields' => function () use (&$User_Account, &$Bank_Transfer){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [blank] =>     [is_null] =>     [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //title: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [is_null] => 1    [size] => 256    [editable] => 1    [readable] => 1)
                    'title' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->title;
                        },
                    ],
                    //currency: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [is_null] =>     [size] => 50    [editable] =>     [readable] => 1)
                    'currency' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->currency;
                        },
                    ],
                    //total_deposit: Array(    [type] => Pluf_DB_Field_Float    [blank] =>     [is_null] =>     [default] => 0    [editable] =>     [readable] => 1)
                    'total_deposit' => [
                        'type' => Type::float(),
                        'resolve' => function ($root) {
                            return $root->total_deposit;
                        },
                    ],
                    //total_withdraw: Array(    [type] => Pluf_DB_Field_Float    [blank] =>     [is_null] =>     [default] => 0    [editable] =>     [readable] => 1)
                    'total_withdraw' => [
                        'type' => Type::float(),
                        'resolve' => function ($root) {
                            return $root->total_withdraw;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [is_null] => 1    [size] => 1024    [editable] => 1    [readable] => 1)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //deleted: Array(    [type] => Pluf_DB_Field_Boolean    [blank] =>     [default] =>     [readable] => 1    [editable] => )
                    'deleted' => [
                        'type' => Type::boolean(),
                        'resolve' => function ($root) {
                            return $root->deleted;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] =>     [is_null] =>     [editable] =>     [readable] => 1)
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [editable] =>     [readable] => 1)
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    //Foreinkey value-owner_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [blank] =>     [is_null] =>     [name] => owner    [graphql_name] => owner    [relate_name] => wallets    [editable] =>     [readable] => 1)
                    'owner_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->owner_id;
                            },
                    ],
                    //Foreinkey object-owner_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [blank] =>     [is_null] =>     [name] => owner    [graphql_name] => owner    [relate_name] => wallets    [editable] =>     [readable] => 1)
                    'owner' => [
                            'type' => $User_Account,
                            'resolve' => function ($root) {
                                return $root->get_owner();
                            },
                    ],
                    // relations: forenkey 
                    
                    //Foreinkey list-from_wallet_id: Array()
                    'withdrawals' => [
                            'type' => Type::listOf($Bank_Transfer),
                            'resolve' => function ($root) {
                                return $root->get_withdrawals_list();
                            },
                    ],
                    //Foreinkey list-to_wallet_id: Array()
                    'deposits' => [
                            'type' => Type::listOf($Bank_Transfer),
                            'resolve' => function ($root) {
                                return $root->get_deposits_list();
                            },
                    ],
                    
                ];
            }
        ]); //
        $Bank_Transfer = new ObjectType([
            'name' => 'Bank_Transfer',
            'fields' => function () use (&$User_Account, &$Bank_Wallet, &$Bank_Receipt){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [blank] =>     [is_null] =>     [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //amount: Array(    [type] => Pluf_DB_Field_Float    [blank] =>     [is_null] =>     [default] => 0    [editable] =>     [readable] => 1)
                    'amount' => [
                        'type' => Type::float(),
                        'resolve' => function ($root) {
                            return $root->amount;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [is_null] => 1    [size] => 1024    [editable] => 1    [readable] => 1)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] =>     [is_null] =>     [editable] =>     [readable] => 1)
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //Foreinkey value-acting_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [blank] =>     [is_null] =>     [name] => acting    [graphql_name] => acting    [relate_name] => wallet_transfers    [editable] =>     [readable] => 1)
                    'acting_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->acting_id;
                            },
                    ],
                    //Foreinkey object-acting_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [blank] =>     [is_null] =>     [name] => acting    [graphql_name] => acting    [relate_name] => wallet_transfers    [editable] =>     [readable] => 1)
                    'acting' => [
                            'type' => $User_Account,
                            'resolve' => function ($root) {
                                return $root->get_acting();
                            },
                    ],
                    //Foreinkey value-from_wallet_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Bank_Wallet    [blank] => 1    [is_null] => 1    [name] => from_wallet    [graphql_name] => from_wallet    [relate_name] => withdrawals    [editable] =>     [readable] => 1)
                    'from_wallet_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->from_wallet_id;
                            },
                    ],
                    //Foreinkey object-from_wallet_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Bank_Wallet    [blank] => 1    [is_null] => 1    [name] => from_wallet    [graphql_name] => from_wallet    [relate_name] => withdrawals    [editable] =>     [readable] => 1)
                    'from_wallet' => [
                            'type' => $Bank_Wallet,
                            'resolve' => function ($root) {
                                return $root->get_from_wallet();
                            },
                    ],
                    //Foreinkey value-to_wallet_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Bank_Wallet    [blank] =>     [is_null] =>     [name] => to_wallet    [graphql_name] => to_wallet    [relate_name] => deposits    [editable] =>     [readable] => 1)
                    'to_wallet_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->to_wallet_id;
                            },
                    ],
                    //Foreinkey object-to_wallet_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Bank_Wallet    [blank] =>     [is_null] =>     [name] => to_wallet    [graphql_name] => to_wallet    [relate_name] => deposits    [editable] =>     [readable] => 1)
                    'to_wallet' => [
                            'type' => $Bank_Wallet,
                            'resolve' => function ($root) {
                                return $root->get_to_wallet();
                            },
                    ],
                    //Foreinkey value-receipt_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Bank_Receipt    [blank] => 1    [is_null] => 1    [name] => receipt    [graphql_name] => receipt    [relate_name] => transfer    [editable] =>     [readable] => 1)
                    'receipt_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->receipt_id;
                            },
                    ],
                    //Foreinkey object-receipt_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Bank_Receipt    [blank] => 1    [is_null] => 1    [name] => receipt    [graphql_name] => receipt    [relate_name] => transfer    [editable] =>     [readable] => 1)
                    'receipt' => [
                            'type' => $Bank_Receipt,
                            'resolve' => function ($root) {
                                return $root->get_receipt();
                            },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $Bank_Receipt = new ObjectType([
            'name' => 'Bank_Receipt',
            'fields' => function () use (&$Bank_Backend, &$Tenant_Invoice, &$Bank_Transfer, &$SDP_Link){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [blank] => 1    [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //amount: Array(    [type] => Pluf_DB_Field_Integer    [blank] =>     [unique] => )
                    'amount' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->amount;
                        },
                    ],
                    //title: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [size] => 50)
                    'title' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->title;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 200)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //email: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 100)
                    'email' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->email;
                        },
                    ],
                    //phone: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 100)
                    'phone' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->phone;
                        },
                    ],
                    //callbackURL: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 200)
                    'callbackURL' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->callbackURL;
                        },
                    ],
                    //payRef: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 200    [readable] => 1)
                    'payRef' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->payRef;
                        },
                    ],
                    //callURL: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 200    [readable] => 1)
                    'callURL' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->callURL;
                        },
                    ],
                    //owner_id: Array(    [type] => Pluf_DB_Field_Integer    [blank] =>     [verbose] => owner ID)
                    'owner_id' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->owner_id;
                        },
                    ],
                    //owner_class: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [size] => 50)
                    'owner_class' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->owner_class;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [verbose] => creation date)
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [verbose] => modification date)
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    //Foreinkey value-backend_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Bank_Backend    [blank] =>     [is_null] =>     [name] => backend    [graphql_name] => backend    [relate_name] => receipts)
                    'backend_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->backend_id;
                            },
                    ],
                    //Foreinkey object-backend_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Bank_Backend    [blank] =>     [is_null] =>     [name] => backend    [graphql_name] => backend    [relate_name] => receipts)
                    'backend' => [
                            'type' => $Bank_Backend,
                            'resolve' => function ($root) {
                                return $root->get_backend();
                            },
                    ],
                    // relations: forenkey 
                    
                    //Foreinkey list-receipt_id: Array()
                    'transfer' => [
                            'type' => Type::listOf($Bank_Transfer),
                            'resolve' => function ($root) {
                                return $root->get_transfer_list();
                            },
                    ],
                    //Foreinkey list-payment_id: Array()
                    'links' => [
                            'type' => Type::listOf($SDP_Link),
                            'resolve' => function ($root) {
                                return $root->get_links_list();
                            },
                    ],
                    
                ];
            }
        ]); //
        $Bank_Backend = new ObjectType([
            'name' => 'Bank_Backend',
            'fields' => function () use (&$Bank_Receipt){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [blank] => 1    [verbose] => unique and no repreducable id fro reception)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //title: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [size] => 50)
                    'title' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->title;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 200)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //symbol: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [size] => 50)
                    'symbol' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->symbol;
                        },
                    ],
                    //home: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 50)
                    'home' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->home;
                        },
                    ],
                    //redirect: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [size] => 50    [secure] => 1)
                    'redirect' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->redirect;
                        },
                    ],
                    //engine: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [size] => 50)
                    'engine' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->engine;
                        },
                    ],
                    //currency: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [is_null] =>     [size] => 50    [editable] =>     [readable] => 1)
                    'currency' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->currency;
                        },
                    ],
                    //deleted: Array(    [type] => Pluf_DB_Field_Boolean    [blank] =>     [default] =>     [readable] => 1    [editable] => )
                    'deleted' => [
                        'type' => Type::boolean(),
                        'resolve' => function ($root) {
                            return $root->deleted;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [verbose] => creation date)
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [verbose] => modification date)
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    // relations: forenkey 
                    
                    //Foreinkey list-backend_id: Array()
                    'receipts' => [
                            'type' => Type::listOf($Bank_Receipt),
                            'resolve' => function ($root) {
                                return $root->get_receipts_list();
                            },
                    ],
                    
                ];
            }
        ]); //
        $Tenant_Invoice = new ObjectType([
            'name' => 'Tenant_Invoice',
            'fields' => function () use (&$Tenant_BankReceipt){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [blank] =>     [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //title: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [is_null] => 1    [size] => 256    [editable] => 1    [readable] => 1)
                    'title' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->title;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [is_null] => 1    [size] => 500    [editable] => 1    [readable] => 1)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //amount: Array(    [type] => Pluf_DB_Field_Integer    [blank] =>     [is_null] => )
                    'amount' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->amount;
                        },
                    ],
                    //due_dtime: Array(    [type] => Pluf_DB_Field_Date    [blank] =>     [is_null] =>     [editable] => 1    [readable] => 1)
                    'due_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->due_dtime;
                        },
                    ],
                    //status: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [is_null] =>     [size] => 50    [editable] =>     [readable] => 1)
                    'status' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->status;
                        },
                    ],
                    //discount_code: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [is_null] => 1    [size] => 50    [editable] =>     [readable] => 1)
                    'discount_code' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->discount_code;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [is_null] => 1    [editable] =>     [readable] => 1)
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [is_null] => 1    [editable] =>     [readable] => 1)
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    //Foreinkey value-payment_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Tenant_BankReceipt    [blank] =>     [editable] =>     [readable] => 1    [name] => payment    [graphql_name] => payment)
                    'payment_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->payment_id;
                            },
                    ],
                    //Foreinkey object-payment_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Tenant_BankReceipt    [blank] =>     [editable] =>     [readable] => 1    [name] => payment    [graphql_name] => payment)
                    'payment' => [
                            'type' => $Tenant_BankReceipt,
                            'resolve' => function ($root) {
                                return $root->get_payment();
                            },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $Tenant_BankReceipt = new ObjectType([
            'name' => 'Tenant_BankReceipt',
            'fields' => function () use (&$Tenant_BankBackend){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [blank] => 1    [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //amount: Array(    [type] => Pluf_DB_Field_Integer    [blank] =>     [unique] => )
                    'amount' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->amount;
                        },
                    ],
                    //title: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [size] => 50)
                    'title' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->title;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 200)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //email: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 100)
                    'email' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->email;
                        },
                    ],
                    //phone: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 100)
                    'phone' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->phone;
                        },
                    ],
                    //callbackURL: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 200)
                    'callbackURL' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->callbackURL;
                        },
                    ],
                    //payRef: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 200    [readable] => 1)
                    'payRef' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->payRef;
                        },
                    ],
                    //callURL: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 200    [readable] => 1)
                    'callURL' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->callURL;
                        },
                    ],
                    //owner_id: Array(    [type] => Pluf_DB_Field_Integer    [blank] =>     [verbose] => owner ID)
                    'owner_id' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->owner_id;
                        },
                    ],
                    //owner_class: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [size] => 50)
                    'owner_class' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->owner_class;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [verbose] => creation date)
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [verbose] => modification date)
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    //Foreinkey value-backend_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Tenant_BankBackend    [blank] =>     [relate_name] => backend)
                    'backend_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->backend_id;
                            },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $Tenant_BankBackend = new ObjectType([
            'name' => 'Tenant_BankBackend',
            'fields' => function () use (&$Pluf_Tenant){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [blank] => 1    [verbose] => unique and no repreducable id fro reception)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //title: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [size] => 50)
                    'title' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->title;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 200)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //symbol: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [size] => 50)
                    'symbol' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->symbol;
                        },
                    ],
                    //home: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 50)
                    'home' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->home;
                        },
                    ],
                    //redirect: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [size] => 50    [secure] => 1)
                    'redirect' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->redirect;
                        },
                    ],
                    //engine: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [size] => 50)
                    'engine' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->engine;
                        },
                    ],
                    //currency: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [is_null] =>     [size] => 50    [editable] =>     [readable] => 1)
                    'currency' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->currency;
                        },
                    ],
                    //deleted: Array(    [type] => Pluf_DB_Field_Boolean    [blank] =>     [default] =>     [readable] => 1    [editable] => )
                    'deleted' => [
                        'type' => Type::boolean(),
                        'resolve' => function ($root) {
                            return $root->deleted;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [verbose] => creation date)
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [verbose] => modification date)
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    //Foreinkey value-tenant: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Pluf_Tenant    [blank] =>     [editable] => )
                    'tenant' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->tenant;
                            },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $Pluf_Tenant = new ObjectType([
            'name' => 'Pluf_Tenant',
            'fields' => function () use (&$Pluf_Tenant){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [blank] => 1    [editable] => )
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //level: Array(    [type] => Pluf_DB_Field_Integer    [blank] => 1    [editable] => )
                    'level' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->level;
                        },
                    ],
                    //title: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 100)
                    'title' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->title;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [is_null] => 1    [size] => 1024    [editable] => 1)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //domain: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [is_null] => 1    [unique] => 1    [size] => 63    [editable] => 1)
                    'domain' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->domain;
                        },
                    ],
                    //subdomain: Array(    [type] => Pluf_DB_Field_Varchar    [blank] =>     [is_null] =>     [unique] => 1    [size] => 63    [editable] => 1)
                    'subdomain' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->subdomain;
                        },
                    ],
                    //validate: Array(    [type] => Pluf_DB_Field_Boolean    [default] =>     [blank] => 1    [editable] => )
                    'validate' => [
                        'type' => Type::boolean(),
                        'resolve' => function ($root) {
                            return $root->validate;
                        },
                    ],
                    //email: Array(    [type] => Pluf_DB_Field_Email    [blank] => 1    [verbose] => Owner email    [editable] => 1    [readable] => 1)
                    'email' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->email;
                        },
                    ],
                    //phone: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [verbose] => Owner phone    [editable] => 1    [readable] => 1)
                    'phone' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->phone;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [editable] => )
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [blank] => 1    [editable] => )
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    //Foreinkey value-parent_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Pluf_Tenant    [blank] => 1    [name] => parent    [graphql_name] => parent    [relate_name] => children    [editable] => 1    [readable] => 1)
                    'parent_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->parent_id;
                            },
                    ],
                    //Foreinkey object-parent_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Pluf_Tenant    [blank] => 1    [name] => parent    [graphql_name] => parent    [relate_name] => children    [editable] => 1    [readable] => 1)
                    'parent' => [
                            'type' => $Pluf_Tenant,
                            'resolve' => function ($root) {
                                return $root->get_parent();
                            },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $SDP_Link = new ObjectType([
            'name' => 'SDP_Link',
            'fields' => function () use (&$SDP_Asset, &$User_Account, &$Bank_Receipt){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [is_null] =>     [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //secure_link: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 50    [editable] =>     [readable] => 1)
                    'secure_link' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->secure_link;
                        },
                    ],
                    //expiry: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] =>     [size] => 50    [editable] =>     [readable] => 1)
                    'expiry' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->expiry;
                        },
                    ],
                    //download: Array(    [type] => Pluf_DB_Field_Integer    [is_null] =>     [size] => 50    [editable] =>     [readable] => 1)
                    'download' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->download;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] =>     [editable] =>     [readable] => 1)
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] =>     [editable] =>     [readable] => 1)
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    //active: Array(    [type] => Pluf_DB_Field_Boolean    [is_null] =>     [editable] =>     [readable] => 1)
                    'active' => [
                        'type' => Type::boolean(),
                        'resolve' => function ($root) {
                            return $root->active;
                        },
                    ],
                    //discount_code: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [is_null] => 1    [size] => 50    [editable] =>     [readable] => 1)
                    'discount_code' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->discount_code;
                        },
                    ],
                    //Foreinkey value-asset_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => SDP_Asset    [name] => asset    [graphql_name] => asset    [relate_name] => links    [is_null] =>     [editable] =>     [readable] => 1)
                    'asset_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->asset_id;
                            },
                    ],
                    //Foreinkey object-asset_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => SDP_Asset    [name] => asset    [graphql_name] => asset    [relate_name] => links    [is_null] =>     [editable] =>     [readable] => 1)
                    'asset' => [
                            'type' => $SDP_Asset,
                            'resolve' => function ($root) {
                                return $root->get_asset();
                            },
                    ],
                    //Foreinkey value-user_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [name] => user    [graphql_name] => user    [relate_name] => links    [is_null] =>     [editable] =>     [readable] => 1)
                    'user_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->user_id;
                            },
                    ],
                    //Foreinkey object-user_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [name] => user    [graphql_name] => user    [relate_name] => links    [is_null] =>     [editable] =>     [readable] => 1)
                    'user' => [
                            'type' => $User_Account,
                            'resolve' => function ($root) {
                                return $root->get_user();
                            },
                    ],
                    //Foreinkey value-payment_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Bank_Receipt    [name] => payment    [graphql_name] => payment    [relate_name] => links    [is_null] =>     [editable] =>     [readable] => 1)
                    'payment_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->payment_id;
                            },
                    ],
                    //Foreinkey object-payment_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => Bank_Receipt    [name] => payment    [graphql_name] => payment    [relate_name] => links    [is_null] =>     [editable] =>     [readable] => 1)
                    'payment' => [
                            'type' => $Bank_Receipt,
                            'resolve' => function ($root) {
                                return $root->get_payment();
                            },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $SDP_Profile = new ObjectType([
            'name' => 'SDP_Profile',
            'fields' => function () use (&$User_Account){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [is_null] =>     [editable] => )
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //level: Array(    [type] => Pluf_DB_Field_Integer    [is_null] =>     [unique] =>     [editable] => )
                    'level' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->level;
                        },
                    ],
                    //access_count: Array(    [type] => Pluf_DB_Field_Integer    [is_null] =>     [unique] =>     [editable] => )
                    'access_count' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->access_count;
                        },
                    ],
                    //validate: Array(    [type] => Pluf_DB_Field_Boolean    [default] =>     [is_null] =>     [editable] => )
                    'validate' => [
                        'type' => Type::boolean(),
                        'resolve' => function ($root) {
                            return $root->validate;
                        },
                    ],
                    //activity_field: Array(    [type] => Pluf_DB_Field_Varchar    [size] => 100    [is_null] => 1    [editable] => 1    [readable] => 1)
                    'activity_field' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->activity_field;
                        },
                    ],
                    //address: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 200)
                    'address' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->address;
                        },
                    ],
                    //mobile_number: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 50    [unique] => )
                    'mobile_number' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->mobile_number;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] =>     [editable] => )
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] =>     [editable] => )
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    //Foreinkey value-account_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [unique] => 1    [name] => account    [graphql_name] => account    [relate_name] => sdp_profiles    [is_null] =>     [editable] => )
                    'account_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->account_id;
                            },
                    ],
                    //Foreinkey object-account_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => User_Account    [unique] => 1    [name] => account    [graphql_name] => account    [relate_name] => sdp_profiles    [is_null] =>     [editable] => )
                    'account' => [
                            'type' => $User_Account,
                            'resolve' => function ($root) {
                                return $root->get_account();
                            },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $CMS_ContentMeta = new ObjectType([
            'name' => 'CMS_ContentMeta',
            'fields' => function () use (&$CMS_Content){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [is_null] =>     [editable] => )
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //key: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 256    [unique] => 1    [editable] => 1)
                    'key' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->key;
                        },
                    ],
                    //value: Array(    [type] => Pluf_DB_Field_Text    [is_null] => 1    [default] =>     [editable] => 1)
                    'value' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->value;
                        },
                    ],
                    //Foreinkey value-content_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => CMS_Content    [name] => content    [graphql_name] => content    [relate_name] => metas    [is_null] => 1    [editable] => 1)
                    'content_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->content_id;
                            },
                    ],
                    //Foreinkey object-content_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => CMS_Content    [name] => content    [graphql_name] => content    [relate_name] => metas    [is_null] => 1    [editable] => 1)
                    'content' => [
                            'type' => $CMS_Content,
                            'resolve' => function ($root) {
                                return $root->get_content();
                            },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $CMS_TermTaxonomy = new ObjectType([
            'name' => 'CMS_TermTaxonomy',
            'fields' => function () use (&$CMS_Term, &$CMS_TermTaxonomy, &$CMS_Content){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [blank] =>     [editable] => )
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //taxonomy: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 128    [default] =>     [editable] => 1)
                    'taxonomy' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->taxonomy;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [blank] => 1    [size] => 2048    [default] =>     [editable] => 1)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //count: Array(    [type] => Pluf_DB_Field_Integer    [blank] =>     [default] => 0    [editable] => )
                    'count' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->count;
                        },
                    ],
                    //Foreinkey value-term_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => CMS_Term    [name] => term    [graphql_name] => term    [relate_name] => term_taxonomies    [is_null] => 1    [editable] => 1)
                    'term_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->term_id;
                            },
                    ],
                    //Foreinkey object-term_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => CMS_Term    [name] => term    [graphql_name] => term    [relate_name] => term_taxonomies    [is_null] => 1    [editable] => 1)
                    'term' => [
                            'type' => $CMS_Term,
                            'resolve' => function ($root) {
                                return $root->get_term();
                            },
                    ],
                    //Foreinkey value-parent_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => CMS_TermTaxonomy    [name] => parent    [graphql_name] => parent    [relate_name] => children    [is_null] => 1    [editable] => 1)
                    'parent_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->parent_id;
                            },
                    ],
                    //Foreinkey object-parent_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => CMS_TermTaxonomy    [name] => parent    [graphql_name] => parent    [relate_name] => children    [is_null] => 1    [editable] => 1)
                    'parent' => [
                            'type' => $CMS_TermTaxonomy,
                            'resolve' => function ($root) {
                                return $root->get_parent();
                            },
                    ],
                    //Foreinkey value-contents_ids: Array(    [type] => Pluf_DB_Field_Manytomany    [model] => CMS_Content    [is_null] => 1    [editable] =>     [name] => contents    [graphql_name] => contents    [relate_name] => term_taxonomies)
                    'contents' => [
                            'type' => Type::listOf($CMS_Content),
                            'resolve' => function ($root) {
                                return $root->get_contents_list();
                            },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $CMS_Term = new ObjectType([
            'name' => 'CMS_Term',
            'fields' => function () use (&$CMS_TermTaxonomy, &$CMS_TermMeta){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [blank] =>     [verbose] => first name    [help_text] => id    [editable] => )
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //name: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 200    [default] =>     [editable] => 1)
                    'name' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->name;
                        },
                    ],
                    //slug: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [unique] => 1    [size] => 256    [editable] => 1)
                    'slug' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->slug;
                        },
                    ],
                    // relations: forenkey 
                    
                    //Foreinkey list-term_id: Array()
                    'term_taxonomies' => [
                            'type' => Type::listOf($CMS_TermTaxonomy),
                            'resolve' => function ($root) {
                                return $root->get_term_taxonomies_list();
                            },
                    ],
                    //Foreinkey list-term_id: Array()
                    'metas' => [
                            'type' => Type::listOf($CMS_TermMeta),
                            'resolve' => function ($root) {
                                return $root->get_metas_list();
                            },
                    ],
                    
                ];
            }
        ]); //
        $CMS_TermMeta = new ObjectType([
            'name' => 'CMS_TermMeta',
            'fields' => function () use (&$CMS_Term){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [is_null] =>     [editable] => )
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //key: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 256    [unique] => 1    [editable] => 1)
                    'key' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->key;
                        },
                    ],
                    //value: Array(    [type] => Pluf_DB_Field_Text    [is_null] => 1    [default] =>     [editable] => 1)
                    'value' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->value;
                        },
                    ],
                    //Foreinkey value-term_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => CMS_Term    [name] => term    [graphql_name] => term    [graphql_field] => 1    [relate_name] => metas    [is_null] => 1    [editable] => 1)
                    'term_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->term_id;
                            },
                    ],
                    //Foreinkey object-term_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => CMS_Term    [name] => term    [graphql_name] => term    [graphql_field] => 1    [relate_name] => metas    [is_null] => 1    [editable] => 1)
                    'term' => [
                            'type' => $CMS_Term,
                            'resolve' => function ($root) {
                                return $root->get_term();
                            },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $SDP_Drive = new ObjectType([
            'name' => 'SDP_Drive',
            'fields' => function () {
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [blank] =>     [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //title: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 64    [editable] => 1    [readable] => 1)
                    'title' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->title;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 512    [editable] => 1    [readable] => 1)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //home: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 256    [editable] => 1    [readable] => 1)
                    'home' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->home;
                        },
                    ],
                    //driver: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 50)
                    'driver' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->driver;
                        },
                    ],
                    //deleted: Array(    [type] => Pluf_DB_Field_Boolean    [is_null] =>     [default] =>     [readable] => 1    [editable] => )
                    'deleted' => [
                        'type' => Type::boolean(),
                        'resolve' => function ($root) {
                            return $root->deleted;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] => 1    [editable] =>     [readable] => 1)
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] => 1    [editable] =>     [readable] => 1)
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $SDP_Category = new ObjectType([
            'name' => 'SDP_Category',
            'fields' => function () use (&$SDP_Category, &$CMS_Content, &$SDP_Asset){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [is_null] =>     [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //name: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 250    [editable] => 1    [readable] => 1)
                    'name' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->name;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] =>     [editable] =>     [readable] => 1)
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] =>     [editable] =>     [readable] => 1)
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 250    [editable] => 1    [readable] => 1)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    //thumbnail: Array(    [type] => Pluf_DB_Field_Varchar    [size] => 1024    [is_null] => 1    [editable] => 1    [readable] => 1)
                    'thumbnail' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->thumbnail;
                        },
                    ],
                    //Foreinkey value-parent_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => SDP_Category    [name] => parent    [graphql_name] => parent    [relate_name] => children    [is_null] => 1    [editable] => 1    [readable] => 1)
                    'parent_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->parent_id;
                            },
                    ],
                    //Foreinkey object-parent_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => SDP_Category    [name] => parent    [graphql_name] => parent    [relate_name] => children    [is_null] => 1    [editable] => 1    [readable] => 1)
                    'parent' => [
                            'type' => $SDP_Category,
                            'resolve' => function ($root) {
                                return $root->get_parent();
                            },
                    ],
                    //Foreinkey value-content_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => CMS_Content    [name] => content    [graphql_name] => content    [relate_name] => categories    [is_null] => 1    [editable] => 1    [readable] => 1)
                    'content_id' => [
                            'type' => Type::int(),
                            'resolve' => function ($root) {
                                return $root->content_id;
                            },
                    ],
                    //Foreinkey object-content_id: Array(    [type] => Pluf_DB_Field_Foreignkey    [model] => CMS_Content    [name] => content    [graphql_name] => content    [relate_name] => categories    [is_null] => 1    [editable] => 1    [readable] => 1)
                    'content' => [
                            'type' => $CMS_Content,
                            'resolve' => function ($root) {
                                return $root->get_content();
                            },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]); //
        $SDP_Tag = new ObjectType([
            'name' => 'SDP_Tag',
            'fields' => function () use (&$SDP_Asset){
                return [
                    // List of basic fields
                    
                    //id: Array(    [type] => Pluf_DB_Field_Sequence    [is_null] =>     [editable] =>     [readable] => 1)
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root) {
                            return $root->id;
                        },
                    ],
                    //name: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] =>     [size] => 250    [editable] => 1    [readable] => 1)
                    'name' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->name;
                        },
                    ],
                    //creation_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] =>     [editable] =>     [readable] => 1)
                    'creation_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->creation_dtime;
                        },
                    ],
                    //modif_dtime: Array(    [type] => Pluf_DB_Field_Datetime    [is_null] =>     [editable] =>     [readable] => 1)
                    'modif_dtime' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->modif_dtime;
                        },
                    ],
                    //description: Array(    [type] => Pluf_DB_Field_Varchar    [is_null] => 1    [size] => 250    [editable] => 1    [readable] => 1)
                    'description' => [
                        'type' => Type::string(),
                        'resolve' => function ($root) {
                            return $root->description;
                        },
                    ],
                    // relations: forenkey 
                    
                    
                ];
            }
        ]);$itemType =$SDP_AssetRelation;$rootType =new ObjectType([
            'name' => 'Pluf_paginator',
            'fields' => function () use (&$itemType){
                return [
                    'counts' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->fetchItemsCount();
                        }
                    ],
                    'current_page' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->current_page;
                        }
                    ],
                    'items_per_page' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->items_per_page;
                        }
                    ],
                    'page_number' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->getNumberOfPages();
                        }
                    ],
                    'items' => [
                        'type' => Type::listOf($itemType),
                        'resolve' => function ($root) {
                            return $root->fetchItems();
                        }
                    ],
                ];
            }
        ]);
        try {
            $schema = new Schema([
                'query' => $rootType
            ]);
            $result = GraphQL::executeQuery($schema, $query, $rootValue);
            return $result->toArray();
        } catch (Exception $e) {
            throw new Pluf_Exception_BadRequest($e->getMessage());
        }
    }
}
