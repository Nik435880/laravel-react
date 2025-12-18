import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { FileImage } from 'lucide-react';
import { SendHorizontal } from 'lucide-react';
import { Form } from '@inertiajs/react';
import { Room } from '@/types';

export const MessageForm = ({ room }: { room: Room }) => {
    return (
        <Form
            method="POST"
            className="flex items-center justify-between gap-1 p-2 border-t dark:border-sidebar-border h-16"
            action={room?.id ? `/rooms/${room.id}` : '#'}
            encType="multipart/form-data"
            resetOnSuccess
        >
            <Input
                type="text"
                name="text"
                id="text"
                placeholder="Enter message..."
                autoComplete="off"
            />
            <Label htmlFor="images" className="flex items-center justify-center ">
                <FileImage size={32} />
            </Label>
            <Input
                id="images"
                name="images[]"
                type="file"
                className="hidden"
                multiple // Allow multiple file selection
            />
            <Button
                type="submit"
                className="rounded-full size-9"
                disabled={!room?.id}
            >
                <SendHorizontal size={32} />
            </Button>
        </Form>
    );
};
