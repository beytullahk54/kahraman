import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { UserModule } from './user/user.module';
import { LessonsModule } from './lessons/lessons.module';

@Module({
  imports: [
    TypeOrmModule.forRoot({
      type: 'mysql', // veya kullanmak istediğiniz diğer veritabanı türü
      host: 'localhost',
      port: 3306,
      username: 'root',
      password: '', // Veritabanı şifreniz
      database: 'nest_app',
      entities: [__dirname + '/**/*.entity{.ts,.js}'],
      synchronize: true,
    }),
    UserModule,
    LessonsModule,
  ],
})
export class AppModule {}
