import { AppContent } from '@/components/app-content';
import { AppShell } from '@/components/app-shell';
import { AppSidebar } from '@/components/app-sidebar';
import { AppSidebarHeader } from '@/components/app-sidebar-header';
import { Room, type BreadcrumbItem } from '@/types';
import { usePage } from '@inertiajs/react';
import { type SharedData } from '@/types';
import { useState } from 'react';
import { useEcho } from "@laravel/echo-react";



export default function AppSidebarLayout({ children }: { children: React.ReactNode; breadcrumbs?: BreadcrumbItem[] }) {

    const { rooms, auth } = usePage<SharedData>().props;

    const [items, setItems] = useState<Room[]>(rooms);

    useEcho('rooms', 'RoomCreated', (e: { room: Room }) => {
        if (e.room.users.find((user: { id: number; }) => user.id === auth.user.id)) {
            setItems((items): Room[] => [...items, e.room]);
        }

    });

    useEcho('rooms', 'RoomUpdated', (e: { room: Room }) => {
        if (e.room.users.find((user: { id: number; }) => user.id === auth.user.id)) {
            setItems((items): Room[] => items.map((item: Room) => item.id === e.room.id ? e.room : item));
        }

    });

    return (
        <AppShell variant="sidebar">
            <AppSidebar items={items} />
            <AppContent variant="sidebar">
                <div className='flex flex-col w-full h-[100vh]'>
                    <AppSidebarHeader />
                    {children}
                </div>
            </AppContent>
        </AppShell>
    );
}
