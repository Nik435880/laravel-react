import { SidebarTrigger } from '@/components/ui/sidebar';
import { usePage } from '@inertiajs/react';
import { Avatar, AvatarImage } from '@/components/ui/avatar';
import { Room, Auth } from "@/types";
import { use, useEffect } from 'react';

export function AppSidebarHeader() {
    const { room, auth } = usePage().props as { room?: Room, auth?: Auth };

    const otherUser = room?.users?.find((user) => user.id !== auth?.user.id);

    useEffect(() => {
        console.log(room);
    }, []);



    return (
        <header className="border-sidebar-border/50 flex h-16 shrink-0 items-center justify-between  gap-2 border-b px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4">
            <div className="flex items-center gap-2">
                <SidebarTrigger className="-ml-1" />
            </div>

            <div className="flex items-center gap-1">
                <Avatar className="h-8 w-8 overflow-hidden rounded-full">
                    <AvatarImage
                        src={room?.name === otherUser?.name ? `/storage/${otherUser?.avatar?.avatar_path}` : `/storage/${room?.image_path}`}
                        alt={`${room?.name === otherUser?.name ? otherUser?.name : room?.name}'`}
                    />
                </Avatar>
                <span className="text-sm font-medium">{room?.name === otherUser?.name ? otherUser?.name : room?.name}</span>

            </div>
        </header>
    );
}
