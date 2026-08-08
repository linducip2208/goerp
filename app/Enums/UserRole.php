<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case PlatformAdmin = 'platform_admin';
    case PlatformSupport = 'platform_support';
    case PlatformBilling = 'platform_billing';
    case Owner = 'owner';
    case Admin = 'admin';
    case Finance = 'finance';
    case Accounting = 'accounting';
    case Sales = 'sales';
    case Purchasing = 'purchasing';
    case Warehouse = 'warehouse';
    case Production = 'production';
    case Cashier = 'cashier';
    case Auditor = 'auditor';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::PlatformAdmin => 'Platform Admin',
            self::PlatformSupport => 'Platform Support',
            self::PlatformBilling => 'Platform Billing',
            self::Owner => 'Pemilik',
            self::Admin => 'Admin',
            self::Finance => 'Finance',
            self::Accounting => 'Akuntansi',
            self::Sales => 'Sales',
            self::Purchasing => 'Purchasing',
            self::Warehouse => 'Gudang',
            self::Production => 'Produksi',
            self::Cashier => 'Kasir',
            self::Auditor => 'Auditor',
        };
    }

    public function isPlatform(): bool
    {
        return in_array($this, [self::SuperAdmin, self::PlatformAdmin, self::PlatformSupport, self::PlatformBilling]);
    }

    public function isCustomer(): bool
    {
        return !$this->isPlatform();
    }

    public static function platformRoles(): array
    {
        return [self::SuperAdmin, self::PlatformAdmin, self::PlatformSupport, self::PlatformBilling];
    }

    public static function customerRoles(): array
    {
        return array_diff(self::cases(), self::platformRoles());
    }
}
