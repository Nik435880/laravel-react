import { Button } from '@/components/ui/button';
import { Form } from '@inertiajs/react';
import { User } from '@/types';
import { store } from "@/actions/App/Http/Controllers/RoomController";

export function RoomForm({ user }: { user: User }) {
    return (
        <Form
            action={store()}
            method="POST"
            transform={(data) => ({ ...data, name: user.name })}
        >
            <Button variant="outline">Send message</Button>
        </Form>
    );
}
