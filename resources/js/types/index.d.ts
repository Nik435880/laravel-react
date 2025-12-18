import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}


export interface Room {
    id: number,
    name: string,
    messages: Message[],
    users:User[]
}


export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    errors: Record<string, string>;
    sidebarOpen: boolean;
    rooms: {
        id: number,
        name: string,
        messages: Message[],
        users: {
            id: number,
            name: string,
            avatar: {
                avatar_path: string
            }
        }[],
    }[]

}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: {
        avatar_path: string
    };
    user_avatar_url?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Image {
    id: number,
    image_path: string,
}

export interface Message {

    id: number,
    text: string,
    created_at: string,
    user: {
        id: number,
        name: string,
        avatar: {
            avatar_path: string
        }
    }
    images: {
        id: number,
        image_path: string,
    }[]
}



