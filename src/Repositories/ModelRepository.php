<?php

namespace Taecontrol\Moonguard\Repositories;

use Throwable;
use Illuminate\Database\Eloquent\Builder;
use Taecontrol\Moonguard\Exceptions\ModelClassNotSetException;
use Taecontrol\Moonguard\Exceptions\ModelContractNotSetException;
use Taecontrol\Moonguard\Exceptions\ModelClassConfigKeyNotSetException;

abstract class ModelRepository
{
    protected static string $contract;

    protected static string $modelClassConfigKey;

    abstract public static function resolveModel();

    public static function query(): Builder
    {
        return static::resolveModelClass()::query();
    }

    /**
     * @throws Throwable
     */
    public static function resolveModelClass(): string
    {
        throw_if(! config(static::getModelClassConfigKey()), new ModelClassNotSetException('Model class not set on config ' . static::getModelClassConfigKey()));

        $modelClass = config(static::getModelClassConfigKey());

        throw_if(! static::modelIsValid(new $modelClass), new ModelContractNotSetException('Model class does not implement ' . static::getContract()));

        return config(static::getModelClassConfigKey());
    }

    /**
     * @throws Throwable
     */
    protected static function modelIsValid(mixed $model): bool
    {
        $contract = static::getContract();

        return $model instanceof $contract;
    }

    /**
     * @throws Throwable
     */
    protected static function getContract(): string
    {
        throw_if(! static::$contract, new ModelContractNotSetException('Model contract not set on ' . static::class));

        return static::$contract;
    }

    /**
     * @throws Throwable
     */
    protected static function getModelClassConfigKey(): string
    {
        throw_if(! static::$modelClassConfigKey, new ModelClassConfigKeyNotSetException('Model class config key not set on ' . static::class));

        return static::$modelClassConfigKey;
    }
}
