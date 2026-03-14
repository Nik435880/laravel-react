import { RoomInfo } from '@/components/room-info';
import { Message, Room, User } from '@/types';
import { Image } from 'lucide-react';
import { useEffect } from 'react';

export function NavLastMessage({
    message,
    user,
    room
}: {
    message: Message | null;
    user: User;
    room: Room
}) {

    useEffect(() => {
        console.log('NavLastMessage rendered with message:', message);
    }, [message, user]);

    if (!message) {
        return (
            <div className="w-full flex flex-col">
                <RoomInfo room={room} />

                <span className="mt-1 text-sm text-gray-400">No messages yet</span>
            </div>
        );
    }

    return (
        <div className="w-full flex flex-col">
            <RoomInfo room={room} />

            <div className="flex flex-col">
                <span className="mt-1 text-sm font-semibold">{message?.user?.name}:</span>

                <div className="flex flex-row gap-1 justify-between">
                    {message.text && (
                        <p className="truncate text-sm">{message.text}</p>
                    )}

                    {message.images?.length > 0 && (
                        <div className="flex items-center gap-1">
                            <Image className="w-4 h-4 text-gray-500" />
                            <span className="text-sm text-gray-500">Photo</span>
                        </div>
                    )}

                </div>


            </div>

            <span className="text-gray-500 text-sm">
                {new Date(message.created_at).toLocaleString()}
            </span>
        </div>
    );
}
