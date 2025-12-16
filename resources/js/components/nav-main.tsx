import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { Link, usePage } from '@inertiajs/react';
import { Avatar, AvatarImage } from '@/components/ui/avatar';
import { Image } from 'lucide-react';
import { Rooms, Room } from '@/types';

export function NavMain({ items }: { items: Rooms[] }) {


    const { auth, url } = usePage().props as unknown as { auth: { user: { name: string, id: number } }, url: string };


    return (
        <SidebarGroup>
            <SidebarGroupLabel>Chats</SidebarGroupLabel>
            <SidebarMenu>
                {items?.map((room: Room) => {


                    const lastMessage = room.messages[room.messages.length - 1] || null;

                    const lastUser = lastMessage?.user;

                    const lastText = lastMessage?.text;

                    const roomName = room.users.find((user: { id: number; name: string; avatar: { avatar_path: string; }; }) => user.id !== auth.user.id)?.name;

                    const avatarPath = room.users.find((user: { id: number; name: string; avatar: { avatar_path: string; }; }) => user.id !== auth.user.id)?.avatar?.avatar_path;

                    return (
                        <SidebarMenuItem key={room.id} >
                            <SidebarMenuButton
                                asChild
                                isActive={`/rooms/${room.id}` === url}
                                tooltip={{ children: roomName }}
                            >
                                <Link href={`/rooms/${room.id}`} className='h-full w-full rounded-none'>
                                    <div>
                                        <div className='flex flex-row items-center gap-1'>
                                            <Avatar>
                                                <AvatarImage src={avatarPath ? `/storage/${avatarPath}` : '/storage/avatars/default.jpg'}
                                                    alt={`${roomName}'s avatar`} />
                                            </Avatar>
                                            <h1 className='text-xl font-bold'>{roomName}</h1>

                                        </div>


                                        {lastText || lastMessage?.images ? <div className='flex flex-col '>


                                            <div className='flex justify-between items-center'>
                                                <h2 className='text-blue-500 font-semibold '>{lastUser?.name}:</h2>

                                                <p className='w-40 truncate'>
                                                    {lastText}
                                                </p>

                                                {lastMessage?.images && lastMessage?.images.length > 0 && (
                                                    <div className="flex items-center ml-2">
                                                        <Image size={16} />
                                                        <span className="text-gray-500 text-sm ml-1">
                                                            {lastMessage?.images.length}
                                                        </span>
                                                    </div>
                                                )}

                                            </div>

                                            <span className='text-gray-400 text-sm '>{new Date(lastMessage?.created_at).toLocaleString() === 'Invalid Date' ? '' : new Date(lastMessage?.created_at).toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true }) || ''}</span>


                                        </div> : <span className='text-gray-700 dark:text-gray-300'>
                                            No messages yet</span>}


                                    </div>
                                </Link>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    );
                })}


            </SidebarMenu>
        </SidebarGroup>
    );
}
