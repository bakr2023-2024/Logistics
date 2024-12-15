<?php
namespace App\Enums;
enum ActivityType: string
{
    case CUSTOMER_LOGIN = 'customer_login';
    case CUSTOMER_LOGOUT = 'customer_logout';
    case CUSTOMER_CREATE = 'customer_created';
    case CUSTOMER_UPDATE = 'customer_updated';
    case CUSTOMER_DELETE = 'customer_deleted';
    case CUSTOMER_PASSWORD_RESET = 'customer_password_reset';
    case ADMIN_LOGIN = 'admin_login';
    case ADMIN_LOGOUT = 'admin_logout';
    case ADMIN_CREATE = 'admin_created';
    case ADMIN_UPDATE = 'admin_updated';
    case ADMIN_DELETE = 'admin_deleted';
    case ADMIN_PASSWORD_RESET = 'admin_password_reset';
    case SHIPMENT_CREATE = 'shipment_created';
    case SHIPMENT_UPDATE = 'shipment_updated';
    case SHIPMENT_DELETE = 'shipment_deleted';
    case TICKET_CREATE = 'ticket_created';
    case TICKET_UPDATE = 'ticket_updated';
    case TICKET_DELETE = 'ticket_deleted';
}
