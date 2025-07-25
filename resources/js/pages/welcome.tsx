import React from 'react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/react';

interface Props {
    count: number;
    [key: string]: unknown;  // REQUIRED for Inertia.js TypeScript compatibility
}

export default function Welcome({ count }: Props) {
    const handleIncrement = () => {
        router.post(route('counter.store'), {}, {
            preserveState: true,
            preserveScroll: true
        });
    };

    return (
        <AppShell>
            <div className="flex flex-col items-center justify-center min-h-[60vh] space-y-8">
                <div className="text-center space-y-4">
                    <h1 className="text-6xl font-bold text-primary">
                        {count}
                    </h1>
                    <p className="text-lg text-muted-foreground">
                        This counter persists across sessions
                    </p>
                </div>
                
                <Button 
                    onClick={handleIncrement}
                    size="lg"
                    className="px-8 py-3 text-lg"
                >
                    Increment Counter
                </Button>
                
                <div className="text-sm text-muted-foreground text-center max-w-md">
                    <p>
                        The counter value is stored in the database and will maintain its state 
                        even after refreshing the page or closing the browser.
                    </p>
                </div>
            </div>
        </AppShell>
    );
}