import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { Link, usePage } from '@inertiajs/react';
import { Room, SharedData } from '@/types';
import { NavLastMessage } from './nav-last-message';

export function NavMain({ items }: { items: Room[] }) {
    const { auth, url } = usePage<SharedData>().props;



    return (
        <SidebarGroup>
            <SidebarGroupLabel>Chats</SidebarGroupLabel>
            <SidebarMenu>
                {items?.map((room: Room) => {
                    const lastMessage = room.messages[room.messages.length - 1] || null;


                    const user =
                        room.users.find((user) => user.id !== auth.user.id) || auth.user;

                    return (
                        <SidebarMenuItem key={room.id}>
                            <SidebarMenuButton
                                asChild
                                isActive={`/rooms/${room.id}` === url}
                                tooltip={{ children: room.name }}
                            >
                                <Link href={`/rooms/${room.id}`} className="h-full w-full">
                                    <NavLastMessage message={lastMessage} user={user} />
                                </Link>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    );
                })}
            </SidebarMenu>
        </SidebarGroup>
    );
}
