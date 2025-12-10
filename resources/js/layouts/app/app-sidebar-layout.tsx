import { AppContent } from '@/components/app-content';
import { AppShell } from '@/components/app-shell';
import { AppSidebar } from '@/components/app-sidebar';
import { AppSidebarHeader } from '@/components/app-sidebar-header';
import { Rooms, Room, type BreadcrumbItem } from '@/types';
import { usePage } from '@inertiajs/react';
import { type SharedData } from '@/types';
import { useState } from 'react';
import { useEcho } from "@laravel/echo-react";



export default function AppSidebarLayout({ children }: { children: React.ReactNode; breadcrumbs?: BreadcrumbItem[] }) {

    const { rooms, auth } = usePage<SharedData>().props;

    const [items, setItems] = useState<Rooms[]>(rooms);

    useEcho('rooms', 'RoomCreated', (e: { room: Room }) => {
        if (e.room.users.find((user: { id: number; }) => user.id === auth.user.id)) {
            setItems((items): Rooms[] => [...items, e.room]);
        }

    });

    useEcho('rooms', 'RoomUpdated', (e: { room: Room }) => {
        if (e.room.users.find((user: { id: number; }) => user.id === auth.user.id)) {
            setItems((items): Rooms[] => items.map((item: Room) => item.id === e.room.id ? e.room : item));
        }

    });

    return (
        <AppShell variant="sidebar">
            <AppSidebar items={items} />
            <AppContent variant="sidebar">
                <AppSidebarHeader />
                {children}
            </AppContent>
        </AppShell>
    );
}