<?php

namespace AlibabaCloud\Codeup\V20200414;

use AlibabaCloud\Client\Resolver\ApiResolver;

/**
 * @method AddGroupMember addGroupMember(array $options = [])
 * @method AddRepositoryMember addRepositoryMember(array $options = [])
 * @method AddWebhook addWebhook(array $options = [])
 * @method CreateBranch createBranch(array $options = [])
 * @method CreateFile createFile(array $options = [])
 * @method CreateMergeRequest createMergeRequest(array $options = [])
 * @method CreateRepository createRepository(array $options = [])
 * @method CreateRepositoryGroup createRepositoryGroup(array $options = [])
 * @method CreateTag createTag(array $options = [])
 * @method DeleteBranch deleteBranch(array $options = [])
 * @method DeleteFile deleteFile(array $options = [])
 * @method DeleteGroupMember deleteGroupMember(array $options = [])
 * @method DeleteRepository deleteRepository(array $options = [])
 * @method DeleteRepositoryGroup deleteRepositoryGroup(array $options = [])
 * @method DeleteRepositoryMember deleteRepositoryMember(array $options = [])
 * @method GetBranchInfo getBranchInfo(array $options = [])
 * @method GetCodeupOrganization getCodeupOrganization(array $options = [])
 * @method GetFileBlobs getFileBlobs(array $options = [])
 * @method GetProjectMember getProjectMember(array $options = [])
 * @method GetRepositoryInfo getRepositoryInfo(array $options = [])
 * @method ListGroupMember listGroupMember(array $options = [])
 * @method ListGroupRepositories listGroupRepositories(array $options = [])
 * @method ListGroups listGroups(array $options = [])
 * @method ListRepositoryMember listRepositoryMember(array $options = [])
 * @method ListRepositoryTree listRepositoryTree(array $options = [])
 * @method MergeMergeRequest mergeMergeRequest(array $options = [])
 * @method UpdateFile updateFile(array $options = [])
 * @method UpdateGroupMember updateGroupMember(array $options = [])
 * @method UpdateRepositoryMember updateRepositoryMember(array $options = [])
 */
class CodeupApiResolver extends ApiResolver
{
}

class Roa extends \AlibabaCloud\Client\Resolver\Roa
{
    /** @var string */
    public $product = 'codeup';

    /** @var string */
    public $version = '2020-04-14';

    /** @var string */
    public $method = 'POST';
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getClientToken()
 * @method string getGroupId()
 * @method $this withGroupId($value)
 * @method string getAccessToken()
 */
class AddGroupMember extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v4/groups/[GroupId]/members';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withClientToken($value)
    {
        $this->data['ClientToken'] = $value;
        $this->options['query']['ClientToken'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getClientToken()
 * @method string getAccessToken()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 */
class AddRepositoryMember extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v4/projects/[ProjectId]/members';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withClientToken($value)
    {
        $this->data['ClientToken'] = $value;
        $this->options['query']['ClientToken'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getAccessToken()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 */
class AddWebhook extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/projects/[ProjectId]/hooks';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getAccessToken()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 */
class CreateBranch extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/projects/[ProjectId]/repository/branches';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getClientToken()
 * @method string getAccessToken()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 */
class CreateFile extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/projects/[ProjectId]/repository/files';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withClientToken($value)
    {
        $this->data['ClientToken'] = $value;
        $this->options['query']['ClientToken'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getAccessToken()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 */
class CreateMergeRequest extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v4/projects/[ProjectId]/merge_requests';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getClientToken()
 * @method string getAccessToken()
 * @method string getSync()
 * @method string getCreateParentPath()
 */
class CreateRepository extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/projects';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withClientToken($value)
    {
        $this->data['ClientToken'] = $value;
        $this->options['query']['ClientToken'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSync($value)
    {
        $this->data['Sync'] = $value;
        $this->options['query']['Sync'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withCreateParentPath($value)
    {
        $this->data['CreateParentPath'] = $value;
        $this->options['query']['CreateParentPath'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getClientToken()
 * @method string getAccessToken()
 */
class CreateRepositoryGroup extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/groups';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withClientToken($value)
    {
        $this->data['ClientToken'] = $value;
        $this->options['query']['ClientToken'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getAccessToken()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 */
class CreateTag extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/projects/[ProjectId]/repository/tags';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getAccessToken()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 * @method string getBranchName()
 * @method $this withBranchName($value)
 */
class DeleteBranch extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/projects/[ProjectId]/repository/branches/[BranchName]';

    /** @var string */
    public $method = 'DELETE';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getFilePath()
 * @method string getAccessToken()
 * @method string getCommitMessage()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 * @method string getBranchName()
 */
class DeleteFile extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/projects/[ProjectId]/repository/files';

    /** @var string */
    public $method = 'DELETE';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withFilePath($value)
    {
        $this->data['FilePath'] = $value;
        $this->options['query']['FilePath'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withCommitMessage($value)
    {
        $this->data['CommitMessage'] = $value;
        $this->options['query']['CommitMessage'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withBranchName($value)
    {
        $this->data['BranchName'] = $value;
        $this->options['query']['BranchName'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getGroupId()
 * @method $this withGroupId($value)
 * @method string getAccessToken()
 * @method string getUserId()
 * @method $this withUserId($value)
 */
class DeleteGroupMember extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/groups/[GroupId]/members/[UserId]';

    /** @var string */
    public $method = 'DELETE';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getAccessToken()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 */
class DeleteRepository extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/projects/[ProjectId]/remove';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getGroupId()
 * @method $this withGroupId($value)
 * @method string getAccessToken()
 */
class DeleteRepositoryGroup extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/groups/[GroupId]/remove';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getAccessToken()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 * @method string getUserId()
 * @method $this withUserId($value)
 */
class DeleteRepositoryMember extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/projects/[ProjectId]/members/[UserId]';

    /** @var string */
    public $method = 'DELETE';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getAccessToken()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 * @method string getBranchName()
 * @method $this withBranchName($value)
 */
class GetBranchInfo extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/projects/[ProjectId]/repository/branches/[BranchName]';

    /** @var string */
    public $method = 'GET';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getOrganizationIdentity()
 * @method $this withOrganizationIdentity($value)
 * @method string getAccessToken()
 */
class GetCodeupOrganization extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v4/organization/[OrganizationIdentity]';

    /** @var string */
    public $method = 'GET';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getAccessToken()
 * @method string getOrganizationId()
 * @method string getRef()
 * @method string getSubUserId()
 * @method string getFilePath()
 * @method string getFrom()
 * @method string getTo()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 */
class GetFileBlobs extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v4/projects/[ProjectId]/repository/blobs';

    /** @var string */
    public $method = 'GET';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withRef($value)
    {
        $this->data['Ref'] = $value;
        $this->options['query']['Ref'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withFilePath($value)
    {
        $this->data['FilePath'] = $value;
        $this->options['query']['FilePath'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withFrom($value)
    {
        $this->data['From'] = $value;
        $this->options['query']['From'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withTo($value)
    {
        $this->data['To'] = $value;
        $this->options['query']['To'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getAccessToken()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 * @method string getUserId()
 * @method $this withUserId($value)
 */
class GetProjectMember extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/projects/[ProjectId]/members/[UserId]';

    /** @var string */
    public $method = 'GET';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getIdentity()
 * @method string getAccessToken()
 */
class GetRepositoryInfo extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/projects/info';

    /** @var string */
    public $method = 'GET';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withIdentity($value)
    {
        $this->data['Identity'] = $value;
        $this->options['query']['Identity'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getGroupId()
 * @method $this withGroupId($value)
 * @method string getPageSize()
 * @method string getAccessToken()
 * @method string getPage()
 */
class ListGroupMember extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/groups/[GroupId]/members';

    /** @var string */
    public $method = 'GET';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withPageSize($value)
    {
        $this->data['PageSize'] = $value;
        $this->options['query']['PageSize'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withPage($value)
    {
        $this->data['Page'] = $value;
        $this->options['query']['Page'] = $value;

        return $this;
    }
}

/**
 * @method string getAccessToken()
 * @method string getIsMember()
 * @method string getOrganizationId()
 * @method string getSearch()
 * @method string getSubUserId()
 * @method string getIdentity()
 * @method $this withIdentity($value)
 * @method string getPageSize()
 * @method string getPage()
 */
class ListGroupRepositories extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/groups/[Identity]/projects';

    /** @var string */
    public $method = 'GET';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withIsMember($value)
    {
        $this->data['IsMember'] = $value;
        $this->options['query']['IsMember'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSearch($value)
    {
        $this->data['Search'] = $value;
        $this->options['query']['Search'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withPageSize($value)
    {
        $this->data['PageSize'] = $value;
        $this->options['query']['PageSize'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withPage($value)
    {
        $this->data['Page'] = $value;
        $this->options['query']['Page'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getIncludePersonal()
 * @method string getSearch()
 * @method string getSubUserId()
 * @method string getPageSize()
 * @method string getAccessToken()
 * @method string getPage()
 */
class ListGroups extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/groups/all';

    /** @var string */
    public $method = 'GET';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withIncludePersonal($value)
    {
        $this->data['IncludePersonal'] = $value;
        $this->options['query']['IncludePersonal'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSearch($value)
    {
        $this->data['Search'] = $value;
        $this->options['query']['Search'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withPageSize($value)
    {
        $this->data['PageSize'] = $value;
        $this->options['query']['PageSize'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withPage($value)
    {
        $this->data['Page'] = $value;
        $this->options['query']['Page'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getQuery()
 * @method string getPageSize()
 * @method string getAccessToken()
 * @method string getPage()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 */
class ListRepositoryMember extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/projects/[ProjectId]/members';

    /** @var string */
    public $method = 'GET';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withQuery($value)
    {
        $this->data['Query'] = $value;
        $this->options['query']['Query'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withPageSize($value)
    {
        $this->data['PageSize'] = $value;
        $this->options['query']['PageSize'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withPage($value)
    {
        $this->data['Page'] = $value;
        $this->options['query']['Page'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getPath()
 * @method string getSubUserId()
 * @method string getAccessToken()
 * @method string getType()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 * @method string getRefName()
 */
class ListRepositoryTree extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v4/projects/[ProjectId]/repository/tree';

    /** @var string */
    public $method = 'GET';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withPath($value)
    {
        $this->data['Path'] = $value;
        $this->options['query']['Path'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withType($value)
    {
        $this->data['Type'] = $value;
        $this->options['query']['Type'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withRefName($value)
    {
        $this->data['RefName'] = $value;
        $this->options['query']['RefName'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getMergeRequestId()
 * @method $this withMergeRequestId($value)
 * @method string getAccessToken()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 */
class MergeMergeRequest extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/projects/[ProjectId]/merge_request/[MergeRequestId]/merge';

    /** @var string */
    public $method = 'PUT';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getAccessToken()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 */
class UpdateFile extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v4/projects/[ProjectId]/repository/files';

    /** @var string */
    public $method = 'PUT';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getGroupId()
 * @method $this withGroupId($value)
 * @method string getAccessToken()
 * @method string getUserId()
 * @method $this withUserId($value)
 */
class UpdateGroupMember extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/groups/[GroupId]/members/[UserId]';

    /** @var string */
    public $method = 'PUT';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}

/**
 * @method string getOrganizationId()
 * @method string getSubUserId()
 * @method string getAccessToken()
 * @method string getProjectId()
 * @method $this withProjectId($value)
 * @method string getUserId()
 * @method $this withUserId($value)
 */
class UpdateRepositoryMember extends Roa
{
    /** @var string */
    public $pathPattern = '/api/v3/projects/[ProjectId]/members/[UserId]';

    /** @var string */
    public $method = 'PUT';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withOrganizationId($value)
    {
        $this->data['OrganizationId'] = $value;
        $this->options['query']['OrganizationId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withSubUserId($value)
    {
        $this->data['SubUserId'] = $value;
        $this->options['query']['SubUserId'] = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function withAccessToken($value)
    {
        $this->data['AccessToken'] = $value;
        $this->options['query']['AccessToken'] = $value;

        return $this;
    }
}
